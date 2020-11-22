<?php

namespace App\Http\Requests;

use App\Rules\Name;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Rules\Password;

class UserSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', new Name],
            'first_name' => ['required', 'string', 'max:255', new Name],
            'last_name' => ['required', 'string', 'max:255', new Name],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'string', new Password],
            'description' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];
    }
}
