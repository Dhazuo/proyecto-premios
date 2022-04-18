<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantRequest;
use App\Logic\Participation;
use App\Models\Participation as GenerateParticipation;
use App\Models\Participant;

class ParticipantController extends Controller
{
    public function register(ParticipantRequest $request)
    {
        //valida si el usuario ya existe
        $validation = $request->only('name', 'last_name', 'email');
        if (Participant::where('ip_address', '=', $request->ip())->exists()) {
            $errors = array(
                'errors' => array(
                    'registered' => 'Ya estás registrado.'
                )
            );
            return response()->json($errors, 401);
        } else {
            //se le asigna la ip del usuario a la ip del request
            $validation['ip_address'] = $request->ip();

            //se llama a la clase generadora del token mandandole como parametros el email
            $generating_token = new Participation($request->email);

            //generateParticipation regresa un string con el email convertido a token
            $participation_token = $generating_token->generateParticipation();
            $validation['participation'] = $participation_token;

            //se crea el participante
            $participant = Participant::create($validation);

            $participation = $this->createParticipation($participation_token, $participant->id);

            return response()->json([
               'participation' => $participation_token
            ]);
            return redirect()->route('participation', $participant->participation);

        }
    }

    //creacion de la participacion
    private function createParticipation($participation_token, $participant_id)
    {
        return GenerateParticipation::create([
            'participant_id' => $participant_id,
            'participation' => $participation_token
        ]);
    }
}
