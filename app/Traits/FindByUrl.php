<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait FindByUrl
{
    static public function findByUrl($url)
    {
        $title = str_replace('-', ' ', $url);
        return static::where('title', '=', $title)->first();
    }

    static public function findOrFailByUrl($url)
    {
        $title = str_replace('-', ' ', $url);
        return static::where('title', '=', $title)->firstOrFail();
    }

    public function getUrlAttribute()
    {
       return Str::of($this->title)->slug('-');
    }
}
