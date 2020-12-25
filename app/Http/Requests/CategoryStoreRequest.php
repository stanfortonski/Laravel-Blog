<?php

namespace App\Http\Requests;

use App\Rules\Title;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
     /**
     * Get the validation attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'content.title' => __('title'),
            'content.content' => __('content'),
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
            'content.title' => ['required', 'string', 'max:255', new Title],
            'content.content' => ['required', 'string', 'max:65535'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];
    }
}
