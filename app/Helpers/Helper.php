<?php

namespace App\Helpers;

class Helper
{
    static public function stripTags(string $str): string
    {
        return strip_tags($str, '<h1><h2><h3><h4><h5><h6><p><br><b><i><strong><mark><a><span><div><li><ul><ol><table><thead><td><tr><th><tbody><blockquote><section><code><pre><aside><figure><img>');
    }

    static public function properUrl(string $str){
        $validChars = preg_replace('/[^a-z0-9\-_]/', '-', mb_strtolower($str));
        return preg_replace(['/(-)+/', '/^-/', '/-$/'], ['-', '', ''], $validChars);
    }
}
