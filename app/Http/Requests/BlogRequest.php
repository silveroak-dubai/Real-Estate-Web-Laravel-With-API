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
            'title'             => ['required','string','max:190'],
            'slug'              => ['required','string','max:190','unique:blogs,slug'],
            'is_comment'        => ['required','in:1,2'],
            'status'            => ['required','in:1,2'],
            'short_description' => ['required','string','max:150'],
            'description'       => ['required','string'],
            'published_date'    => ['required','date'],
            'image'             => ['required','image','mimes:png,jpg','max:512'],
            'meta_title'        => ['nullable','string','max:80'],
            'meta_description'  => ['nullable','string','max:170']
        ];

        if(request()->update_id){
            $rules['slug'][3]   = 'unique:blogs,slug,'.request()->update_id;
            $rules['image'][0]  = 'nullable';
        }

        return $rules;
    }
}
