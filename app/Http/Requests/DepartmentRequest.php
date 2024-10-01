<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class DepartmentRequest extends FormRequest
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
            'name'             => ['required','string','max:190'],
            'slug'             => ['required','string','max:190','unique:departments,slug'],
            'status'           => ['required','in:1,2'],
            'meta_title'       => ['nullable','string','max:80'],
            'meta_description' => ['nullable','string','max:180'],
        ];

        if(request()->update_id){
            $rules['slug'][3] = 'unique:departments,slug,'.request()->update_id;
        }

        return $rules;
    }
}
