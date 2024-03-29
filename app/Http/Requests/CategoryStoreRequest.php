<?php

namespace App\Http\Requests;

use App\Rules\IsLang;
use App\Rules\PartOfUrl;
use App\Rules\Title;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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

    /**
     * Get the validation attributes
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'content' => __('content'),
            'content.title' => __('title'),
            'content.lang' => __('lang'),
            'content.content' => __('content'),
            'content.url' => __('url'),
            'thumbnail_path' => __('thumbnail')
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
            'content' => ['required', 'array'],
            'content.title' => ['required', 'string', 'max:255', new Title],
            'content.lang' => ['required', 'string', new IsLang],
            'content.url' => ['required', 'string', 'max:255', new PartOfUrl],
            'content.content' => ['required', 'string', 'max:65535'],
            'thumbnail_path' => ['nullable', 'string', 'max:255']
        ];
    }
}
