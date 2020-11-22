<?php

namespace App\Http\Requests;

use App\Rules\Title;
use Illuminate\Foundation\Http\FormRequest;

class PostSaveRequest extends FormRequest
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
     * Get the validation attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => __('title'),
            'content' => __('content'),
            'is_visible' => __('visible'),
            'publish_at' => __('publish at'),
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
            'content' => ['required', 'string', 'max:65535'],
            'is_visible' => ['required', 'boolean'],
            'publish_at_date' => ['nullable', 'date'],
            'publish_at_time' => ['nullable', 'date_format:H:i'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];
    }
}
