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
        'thumbnail_path'
    ];

    public function getThumbnailAttribute()
    {
        return asset('storage/public/thumbnails/'.$this->thumbnail_path);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_of_categories', 'category_id', 'post_id');
    }

    public function content(){
        return $this->belongsToMany(Content::class, 'contents_of_categories', 'category_id', 'content_id')->where('lang', '=', app()->getLocale());
    }

    public function contents(){
        return $this->belongsToMany(Content::class, 'contents_of_categories', 'category_id', 'content_id');
    }

    public function scopeSearch($query, $searchData)
    {
        if (!empty($searchData)){
            $searchData = trim($searchData);
            $queries = explode(' ', $searchData);
            $query->distinct()->select(['categories.*', 'categories.id as id'])
            ->join('contents_of_categories', 'categories.id', '=', 'contents_of_categories.category_id')
            ->join('contents', 'contents.id', '=', 'contents_of_categories.content_id')
            ->where('contents.lang', '=', app()->getLocale());

            foreach ($queries as $q){
                $query->where('contents.title', 'like', '%'.$q.'%')
                ->orWhere('contents.content', 'like', '%'.$q.'%');
            }
        }
        return $query;
    }

    static public function findOrFailByUrl($url)
    {
        return static::selectByUrl($url)->firstOrFail();
    }

    static public function findByUrl($url)
    {
        return static::selectByUrl($url)->first();
    }

    static private function selectByUrl($url)
    {
        $title = str_replace('-', ' ', $url);
        return static::select(['categories.*', 'categories.id as id'])->distinct()
        ->join('contents_of_categories', 'categories.id', '=', 'contents_of_categories.category_id')
        ->join('contents', 'contents.id', '=', 'contents_of_categories.content_id')
        ->where('contents.lang', '=', app()->getLocale())
        ->where('contents.title', '=', $title);
    }
}
