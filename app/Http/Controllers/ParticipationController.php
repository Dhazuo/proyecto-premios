<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Participation;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParticipationController extends Controller
{
    public function index(Request $request, $participation)
    {
        //comprueba si la participación existe
        $participation_exist = Participant::where('participation', $participation)->first();
        if (!$participation_exist) {
            return redirect()->route('index');
        }

        //comprueba si el usuario que está tratando de entrar existe
        $registered_user = Participant::where('ip_address', '=', $request->ip())->first();
        if (!$registered_user) {
            return redirect()->route('index');
        }

        //comprueba si el usuario que intenta entrar es dueño de la participación
        $participation_owner = Participation::where('participation', $participation)->first();

        if ($participation_owner->first()->participant_id != $registered_user->first()->id) {
            return redirect()->route('index');
        }
        $participant_status_prop = $registered_user->status;
        $participant_award = $registered_user->award;
        $participant_code = $registered_user->code;

        $check = Tracking::where('participant_id', $registered_user->id)->first();

        if ($check == null) {
            $participant_tracking = '';
        } else {
            $participant_tracking = $registered_user->tracking->tracking;
        }

        return Inertia::render('Participation', compact('participation_owner', 'participant_status_prop', 'participant_award', 'participant_code', 'participant_tracking'));
    }
}
