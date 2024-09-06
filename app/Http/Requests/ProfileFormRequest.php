<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class ProfileFormRequest extends FormRequest
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
        $rules = [
            'name'      => ['required','string','max:150'],
            'email'     => ['required','string','email','unique:users,email,'.auth()->user()->id],
            'mobile_no' => ['required','string','max:20','unique:users,mobile_no,'.auth()->user()->id],
            'gender'    => ['required','in:1,2'],
            'image'     => ['nullable','image','mimes:png,jpg','max:512']
        ];

        return $rules;
    }
}
