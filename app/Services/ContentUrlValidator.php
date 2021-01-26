<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Validation\Rule;

trait ContentUrlValidator
{
    public function validateContentUrlWithoutOne($request, Content $content){
        $this->validate($request, ['content.url' => Rule::unique('contents', 'url')->ignore($content->id)]);
    }

    public function validateContentUrl($request){
        $this->validate($request, ['content.url' => Rule::unique('contents', 'url')]);
    }
}
