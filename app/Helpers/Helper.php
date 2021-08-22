<?php

namespace App\Helpers;

class Helper
{
    static public function stripTags(string $str): string
    {
        return strip_tags($str, '<h1><h2><h3><h4><h5><h6><p><br><b><i><u><strong><small><mark><a><span><div><li><ul><ol><table><thead><td><tr><th><tbody><tfoot><blockquote><section><code><pre><aside><figure><figcaption><img><iframe><video><audio><article><canvas><svg><source><legend><label><form><input><button><header><footer><nav><sub><sup><textarea><select><option><progress><hr><address><abbr>');
    }

    static public function properUrl(string $str)
    {
        $validChars = preg_replace('/[^a-z0-9\-_]/', '-', mb_strtolower($str));
        return preg_replace(['/(-)+/', '/^-/', '/-$/'], ['-', '', ''], $validChars);
    }
}
