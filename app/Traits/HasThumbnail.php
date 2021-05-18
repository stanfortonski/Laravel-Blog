<?php

namespace App\Traits;

trait HasThumbnail
{
    public function getThumbnailAttribute()
    {
        return asset('storage/thumbnails/'.$this->thumbnail_path);
    }
}
