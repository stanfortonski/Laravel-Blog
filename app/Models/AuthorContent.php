<?php

namespace App\Models;

use App\Traits\HasDescription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorContent extends Model
{
    use HasFactory, HasDescription;

    public $timestamps = false;

    protected $fillable = [
        'author_id',
        'lang',
        'content'
    ];
}
