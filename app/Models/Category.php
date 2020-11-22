<?php

namespace App\Models;

use App\Interfaces\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements Searchable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'thumbnail_path'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_of_categories', 'category_id', 'post_id');
    }

    public function getThumbnailAttribute()
    {
        return asset('storage/public/thumbnails/'.$this->thumbnail_path);
    }

    public function scopeSearch($query, $searchData)
    {
        if (!empty($searchData)){
            $searchData = trim($searchData);
            $queries = explode(' ', $searchData);
            foreach ($queries as $q){
                $query->where('title', 'like', '%'.$q.'%')
                ->orWhere('description', 'like', '%'.$q.'%');
            }
        }
        return $query;
    }
}
