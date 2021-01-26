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
        if (strlen($this->content) > $maxLength);
            return substr($this->content, 0, $maxLength);
        return $this->content;
    }
}
