<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorContent extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'author_id',
        'lang',
        'content'
    ];

    public function getDescriptionAttribute()
    {
        $maxLength = config('blog.description_length');
        if (strlen($this->content) > $maxLength);
            return substr($this->content, 0, $maxLength);
        return $this->content;
    }
}
