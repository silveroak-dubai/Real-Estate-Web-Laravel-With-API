<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class UserRequest extends FormRequest
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
            'email'     => ['required','string','email','unique:users,email'],
            'mobile_no' => ['required','unique:users,mobile_no'],
            'password'  => ['required','min:6','max:16','confirmed'],
            'gender'    => ['required','in:1,2'],
            'is_active' => ['required','in:1,2'],
            'permission'=>['required','array'],
            'image'     =>['nullable','image','mimes:png,jpg']
        ];

        if(request()->update_id){
            $rules['email'][3]                 = 'unique:users,email,'.request()->update_id;
            $rules['mobile_no'][0]             = 'nullable';
            $rules['mobile_no'][1]             = 'unique:users,mobile_no,'.request()->update_id;
            $rules['image'][0]                 = 'nullable';
            $rules['password'][0]              = 'nullable';
        }

        return $rules;
    }
}
