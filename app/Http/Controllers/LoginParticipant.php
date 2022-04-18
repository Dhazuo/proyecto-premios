<?php

namespace App\Http\Controllers;

use App\Models\Participation;
use Illuminate\Http\Request;

class LoginParticipant extends Controller
{
    public function login(Request $request)
    {
        $code = $request->validate([
            'participation_code' => 'alpha_num'
        ],
        [
            'participation_code.alpha_num' => 'Sólo carácteres alfa numéricos.'
        ]);
        $exist = Participation::where('participation', $code)->first();

        if ($exist == null) {
            return response()->json([
                'errors' => [
                    'no_result' => 'Lo sentimos. Esa participación no existe.'
                ]
            ], 401);
        }

        $code_redirect = $request->get('participation_code');
        return redirect()->route('participation', $code_redirect);
    }
}
