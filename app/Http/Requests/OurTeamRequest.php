<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class OurTeamRequest extends FormRequest
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
            "full_name"        => ['required','string','max:100'],
            "position"         => ['required','string','max:120'],
            "experience"       => ['required','string','max:30'],
            "department_id"    => ['required','integer'],
            "description"      => ['required','string'],
            "meta_title"       => ['nullable','string','max:80'],
            "meta_description" => ['nullable','string','max:180'],
            "status"           => ['required','in:1,2,3'],
            "specialized_id"   => ['required','integer'],
            "languages"        => ['required','array'],
            "image"            => ['required','image','mimes:png,jpg','max:512'],
            "alt_text"         => ['nullable','string','max:100'],
        ];

        if(request()->update_id){
            $rules['image'][0] = 'nullable';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'department_id.required'=>'The department field is required.',
        ];
    }
}
