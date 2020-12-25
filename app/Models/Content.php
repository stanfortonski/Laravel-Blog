<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'lang',
        'title',
        'content'
    ];

    public function getDescriptionAttribute()
    {
        $maxLength = config('blog.description_length');
        if (strlen($this->content) > $maxLength);
            return substr($this->content, 0, $maxLength);
        return $this->content;
    }

    public function getUrlAttribute()
    {
       return Str::of($this->title)->slug('-');
    }
}
