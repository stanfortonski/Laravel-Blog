<?php

namespace App\Models;

use App\Interfaces\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Searchable, Feedable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'is_visible',
        'thumbnail_path',
        'publish_at',
        'author_id',
        'tags'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'publish_at' => 'datetime'
    ];

    public function getThumbnailAttribute()
    {
        return asset('storage/thumbnails/'.$this->thumbnail_path);
    }

    public function isVisible()
    {
        return $this->is_visible && empty($this->publish_at);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'posts_of_categories', 'post_id', 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function content()
    {
        return $this->belongsToMany(Content::class, 'contents_of_posts', 'post_id', 'content_id')->where('lang', '=', app()->getLocale());
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class, 'contents_of_posts', 'post_id', 'content_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', 1)->whereNull('publish_at');
    }

    public function scopeNotVisible($query)
    {
        return $query->where('is_visible', 0)->orWhereNotNull('publish_at');
    }

    public function scopeSearch($query, $searchData)
    {
        if (!empty($searchData)){
            $searchData = trim($searchData);
            $queries = explode(' ', $searchData);
            $query->distinct()->select(['posts.*', 'posts.id as id'])
            ->join('contents_of_posts', 'posts.id', '=', 'contents_of_posts.post_id')
            ->join('contents', 'contents.id', '=', 'contents_of_posts.content_id')
            ->where('contents.lang', '=', app()->getLocale());

            foreach ($queries as $q){
                $query->where('contents.title', 'like', '%'.$q.'%')
                ->orWhere('contents.content', 'like', '%'.$q.'%');
            }
        }
        return $query;
    }

    public function toFeedItem()
    {
        $content = $this->content->first();
        return FeedItem::create()
            ->id($this->id)
            ->title($content->title)
            ->summary($content->description)
            ->updated($this->post->updated_at)
            ->link(route('posts.show', [app()->getLocale(), $content->url]))
            ->author($this->author->full_name);
    }

    public static function getFeedItems()
    {
        return static::all();
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
        return static::select(['posts.*', 'posts.id as id'])->distinct()
        ->join('contents_of_posts', 'posts.id', '=', 'contents_of_posts.post_id')
        ->join('contents', 'contents.id', '=', 'contents_of_posts.content_id')
        ->where('contents.lang', '=', app()->getLocale())
        ->where('contents.title', '=', $title);
    }
}
