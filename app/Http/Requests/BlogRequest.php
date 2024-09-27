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
            'slug'              => ['required','string','max:190','unique:posts,slug'],
            'visibility'        => ['required','in:1,2'],
            'status'            => ['required','in:1,2,3'],
            'short_description' => ['required','string','max:180'],
            'description'       => ['required','string'],
            'published_date'    => ['required','date'],
            'feature_image'     => ['required','image','mimes:png,jpg','max:512'],
            'alt_text'          => ['nullable','max:150'],
            'meta_title'        => ['nullable','string','max:80'],
            'meta_description'  => ['nullable','string','max:170']
        ];

        if(request()->update_id){
            $rules['slug'][3]   = 'unique:posts,slug,'.request()->update_id;
            $rules['feature_image'][0]  = 'nullable';
        }

        return $rules;
    }
}
