<?php

namespace App\Services;

use App\Models\Content;

trait CategoryContentUrlValidator
{
    use ContentUrlValidator;

    public function validateContentUrlWithoutOne($request, $content){
        return $this->baseValidateContentUrlWithoutOne(Content::class, $request, $content);
    }

    public function validateContentUrl($request){
        return $this->baseValidateContentUrl(Content::class, $request);
    }
}
