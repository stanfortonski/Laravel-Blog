<?php

namespace App\Traits;

trait HasThumbnail
{
    public function getThumbnailAttribute()
    {
        return $this->thumbnail_path;
    }
}
