<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class BlogRequest extends FormRequest
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
            'title'      => ['required','string','max:190'],
            'slug'       => ['required','string','unique:blogs,slug'],
            'except'     => ['required','max:180'],
            'is_comment' => ['required','in:1,2'],
            'status'     => ['required','in:1,2'],
            'content'    => ['required','string'],
            'image'      => ['required','image','mimes:png,jpg']
        ];

        if(request()->update_id){
            $rules['slug'][2]   = 'unique:blog,slug,'.request()->update_id;
            $rules['image'][0]  = 'nullable';
        }

        return $rules;
    }
}
