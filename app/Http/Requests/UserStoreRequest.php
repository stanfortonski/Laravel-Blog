<?php

namespace App\Http\Requests;

use App\Rules\IsLang;
use App\Rules\Name;
use App\Rules\RealName;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Rules\Password;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'lang' => __('lang'),
            'name' => __('Name'),
            'first_name' => __('First Name'),
            'last_name' => __('Last Name'),
            'content' => __('content'),
            'website' => __('website'),
            'thumbnail_path' => __('thumbnail'),
            'roles' => __('Roles'),
            'password' => __('Password')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'lang' => ['required', 'string', new IsLang],
            'name' => ['required', 'string', 'max:255', new Name],
            'first_name' => ['required', 'string', 'max:255', new RealName],
            'last_name' => ['required', 'string', 'max:255', new RealName],
            'email' => ['required', 'email'],
            'content' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'thumbnail_path' => ['nullable', 'string', 'max:255'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['nullable', 'integer', 'exists:roles,id'],
            'password' => ['sometimes', 'string', new Password]
        ];
    }
}
