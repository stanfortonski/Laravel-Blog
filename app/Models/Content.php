<?php

namespace App\Models;

use App\Traits\HasDescription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory, HasDescription;

    protected $fillable = [
        'lang',
        'title',
        'content',
        'url'
    ];
}
