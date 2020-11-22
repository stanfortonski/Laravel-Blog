<?php

namespace App\Http\Requests;

use App\Rules\Title;
use Illuminate\Foundation\Http\FormRequest;

class CategorySaveRequest extends FormRequest
{
     /**
     * Get the validation attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => __('title'),
            'description' => __('description'),
            'thumbnail' => __('thumbnail')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255', new Title],
            'description' => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];
    }
}
