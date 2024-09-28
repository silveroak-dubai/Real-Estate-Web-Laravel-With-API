<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class TestimonialRequest extends FormRequest
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
            'name'     => ['required','string','max:100'],
            'role'     => ['required','string','max:50'],
            'rating'   => ['required','integer','max:5'],
            'feedback' => ['required','string'],
            'status'   => ['required','in:1,2'],
            'image'    => ['required','image','mimes:png,jpg','max:512'],
        ];

        if(request()->update_id){
            $rules['image'][0] = 'nullable';
        }

        return $rules;
    }
}
