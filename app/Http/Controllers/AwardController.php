<?php

namespace App\Http\Controllers;

use App\Logic\Award;
use App\Logic\Tracking;
use App\Models\Award as AwardModel;
use App\Models\Code;
use App\Models\Participant;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tracking as TrackingModel;

class AwardController extends Controller
{

    const AWARDS = array(
        'REFRIGERADOR ALGO',
        'COCINA ALGO',
        'SILLON ALGO',
        'CAMA ALGO'
    );

    const OUT_OF_STOCK = 'Ooops, parece que nuestros premios se terminaron por hoy. Inténtalo de nuevo mañana.';

    public function register(Request $request)
    {
        $user_response = $request->get('response');
        $user_participation = $request->get('participation');

        if ($user_response == 'no') {
            return response()->json([
                'message' => 'Entendido. Recuerda que puedes reclamar tu premio en cualquier momento.'
            ]);
        }

        //si el participante ya está registrado con premio
        $participant = Participant::where('participation', $user_participation)->first();
        if (
            $participant->status == 'allowed' &&
            $participant->award_type
        ) {
            return response()->json([
                'errors' => [
                    'attempts' => 'Inténtelo de nuevo más tarde.'
                ]
            ], 401);
        }
        //se escoge el tipo de premio
        $award_type = $this->selectAwardType();

        if ($award_type == 'PREMIO_FÍSICO') {
            //incia las validaciones del premio
            $award = $this->selectAward();

            if ($award == self::OUT_OF_STOCK) {
                $participant->status = 'not_allowed';
                return response()->json([
                    'errors' => [
                        'out_of_stock' => $award
                    ]
                ], 422);
            }

            $this->allowUser($participant);
            $this->assignAward($participant, $award);

            DB::table('awards')
                ->where('award', $participant->award)
                ->decrement('availability', 1);

            $this->createTracking($user_participation);
            return response()->json([
                'status' => $participant->status,
                'award' => $participant->award,
                'tracking' => $participant->tracking->tracking
            ]);
        } else {
            $code = $this->selectCode();

            if ($code == self::OUT_OF_STOCK) {
                $participant->status = 'not_allowed';
                return response()->json([
                    'errors' => [
                        'out_of_stock' => $code
                    ]
                ], 422);
            }

            $this->allowUser($participant);
            $this->assignCode($participant, $code);

            $this->createTracking($user_participation);
            return response()->json([
                'status' => $participant->status,
                'code' => $participant->code,
                'tracking' => $participant->tracking->tracking
            ]);
        }

    }

    private function selectAwardType(): string
    {
        $probability = rand(0, 100);
        if ($probability >= 26) {
            return 'CÓDIGO';
        } else {
            return 'PREMIO_FÍSICO';
        }
    }

    private function selectAward(): string
    {
        $award = new Award(self::AWARDS);
        $selected = $award->selectedAward();
        if (in_array($selected, AwardModel::AWARDS)) {
            $return_info = $this->comprobation($selected);
            return $return_info;
        }
    }

    private function selectCode(): string
    {
        $code = Code::where('status', '=', 'available')->latest()->first();

        if ($code) {
            return $code->code;
        } else {
            $error = self::OUT_OF_STOCK;
            return $error;
        }
    }

    private function comprobation($award): string
    {
        $search_award = AwardModel::where('award', $award)->first();
        $date = date('d-m-Y');
        if ($search_award->date != $date){
            $new_award = AwardModel::where('date', $date)
                                    ->where('availability', '>=', 1)
                                    ->first();
            if ($new_award) {
                return $new_award->award;
            } else {
                $error = self::OUT_OF_STOCK;
                return $error;
            }
        } else {
            if ($search_award->availability <= 0) {
                $new_award = AwardModel::where('date', $date)
                    ->where('availability', '>=', 1)
                    ->first();
                if ($new_award) {
                    return $new_award->award;
                } else {
                    $error = self::OUT_OF_STOCK;
                    return $error;
                }
            } else {
                return $search_award->award;
            }
        }

    }
    
    private function allowUser($participant)
    {
        $participant->status = 'allowed';
        $participant->save();
    }

    private function assignAward($participant, $award)
    {

        if (!$participant->award) {
            $participant->award_type = 'PREMIO_FÍSICO';
            $participant->award = $award;
            $participant->save();
        }
    }

    private function assignCode($participant, $code)
    {
        if (!$participant->code) {
            $participant->award_type = 'CÓDIGO';
            $participant->code = $code;
            $participant->save();
        }
        $set_code_status = Code::where('code', $code)->first();
        $set_code_status->status = 'expired';
        $set_code_status->save();
    }

    private function createTracking($user_participation)
    {
        $create_tracking = new Tracking();
        $tracking = $create_tracking->tracking();

        $user = Participant::where('participation', $user_participation)->first();
        $participation = Participation::where('participant_id', $user->id)->first();

        $participation->participation_completed = true;
        $participation->save();

        return TrackingModel::create([
            'participant_id' => $user->id,
            'participation_id' => $participation->id,
            'tracking' => $tracking
        ]);
    }

}
