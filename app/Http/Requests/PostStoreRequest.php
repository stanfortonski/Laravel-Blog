<?php

namespace App\Http\Requests;

use App\Rules\PartOfUrl;
use App\Rules\Title;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'content' => __('content'),
            'content.title' => __('title'),
            'content.content' => __('content'),
            'content.url' => __('url'),
            'publish_at' => __('publish at'),
            'thumbnail' => __('thumbnail'),
            'categories' => __('Categories'),
            'tags' => __('Tags')
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
            'content' => ['required', 'array'],
            'content.title' => ['required', 'string', 'max:255', new Title],
            'content.url' => ['required', 'string', 'max:255', new PartOfUrl],
            'content.content' => ['required', 'string', 'max:65535'],
            'publish_at_date' => ['nullable', 'date'],
            'publish_at_time' => ['nullable', 'date_format:H:i'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', 'exists:categories,id'],
            'tags' => ['nullable', 'string', 'max:255']
        ];
    }
}
