<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class AchievementRequest extends FormRequest
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
            'alt_text'   => ['nullable','string','max:190'],
            'status'     => ['required','in:1,2'],
            'image'      => ['required','image','mimes:png,jpg']
        ];

        if (request()->update_id) {
            $rules['image']  = 'nullable';
        }

        return $rules;
    }
}
