<?php

namespace App\Traits;

trait HasDescription
{
    public function getDescriptionAttribute()
    {
        $maxLength = config('blog.description_length');
        if (strlen($this->content) > $maxLength)
            $result = substr($this->content, 0, $maxLength);
        else $result = $this->content;
        return strip_tags(html_entity_decode($result));
    }
}
