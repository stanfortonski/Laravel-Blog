<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Validation\Rule;

trait ContentUrlValidator
{
    public function validateContentUrlWithoutOne($request, Content $content){
        return Content::where('url', '=', $request->content['url'])->where('lang', '=', app()->getLocale())->where('id', '!=', $content->id)->count() == 0;
    }

    public function validateContentUrl($request){
        return Content::where('url', '=', $request->content['url'])->where('lang', '=', app()->getLocale())->count() == 0;
    }
}

