<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PasswordFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password'      => ['required','string'],
            'password'              => ['required','string','min:8','max:16','confirmed'],
            'password_confirmation' => ['required','string','min:8','max:16'],
        ];
    }

    public function messages()
    {
        return [
            'password.required'=>'The new password field is required.'
        ];
    }
}
