<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:pre_registrations,email',
            ],
            'cv' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120', // 5 MB
            ],
            'linkedin_url' => [
                'nullable',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?linkedin\.com\/.+/i',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email'    => 'Ingresá un email válido.',
            'email.unique'   => 'Este email ya está pre registrado.',
            'cv.mimes'       => 'El CV debe ser PDF, DOC o DOCX.',
            'cv.max'         => 'El CV no puede pesar más de 5 MB.',
            'linkedin_url.regex' => 'Debe ser una URL de LinkedIn válida.',
        ];
    }
}
