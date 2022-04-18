<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|alpha',
            'last_name' => 'required|min:2|alpha',
            'email' => 'required|unique:participants,email|email',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Campo nombre obligatorio.',
            'name.min' => 'El campo nombre debe tener al menos :min carácteres.',
            'name.alpha' => 'El campo nombre sólo puede tener carácteres alfabéticos.',
            'last_name.min' => 'El campo apellido debe tener al menos :min carácteres.',
            'last_name.required' => 'Campo apellido obligatorio.',
            'last_name.alpha' => 'El campo apellido sólo puede tener carácteres alfabéticos.',
            'email.unique' => 'El email ya está registrado.',
            'email.required' => 'Campo email obligatorio.',
            'email.email' => 'Email no válido.',
        ];
    }
}
