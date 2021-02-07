<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'lang',
        'title',
        'content',
        'url'
    ];

    public function getDescriptionAttribute()
    {
        $maxLength = config('blog.description_length');
        if (strlen($this->content) > $maxLength)
            $result = substr($this->content, 0, $maxLength);
        else $result = $this->content;
        return strip_tags(html_entity_decode($result));
    }
}
