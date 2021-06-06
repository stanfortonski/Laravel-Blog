<?php

namespace App\Services;

use App\Models\Content;

trait ContentUrlValidator
{
    public function baseValidateContentUrlWithoutOne($usedClass, $request, $content){
        return $usedClass::where('url', '=', $request->content['url'])->where('lang', '=', app()->getLocale())->where('id', '!=', $content->id)->count() == 0;
    }

    public function baseValidateContentUrl($usedClass, $request){
        return $usedClass::where('url', '=', $request->content['url'])->where('lang', '=', app()->getLocale())->count() == 0;
    }
}
