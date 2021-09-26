<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'thumbnail_path' => ['nullable', 'string', 'max:255'],
        ];
    }
}
