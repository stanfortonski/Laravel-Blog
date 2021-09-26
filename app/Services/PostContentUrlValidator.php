<?php

namespace App\Services;

use App\Models\PostContent;

trait PostContentUrlValidator
{
    use ContentUrlValidator;

    public function validateContentUrlWithoutOne($request, $content)
    {
        return $this->baseValidateContentUrlWithoutOne(PostContent::class, $request, $content);
    }

    public function validateContentUrl($request)
    {
        return $this->baseValidateContentUrl(PostContent::class, $request);
    }
}
