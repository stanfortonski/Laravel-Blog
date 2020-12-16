<?php

namespace App\Models;

use App\Interfaces\Searchable;
use App\Traits\HasUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Searchable, Feedable
{
    use HasFactory, HasUrl;

    protected $casts = [
        'is_visible' => 'boolean',
        'publish_at' => 'datetime'
    ];

    protected $fillable = [
        'title',
        'content',
        'is_visible',
        'thumbnail_path',
        'publish_at',
        'author_id'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'posts_of_categories', 'post_id', 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function getDescriptionAttribute()
    {
        $maxLength = config('blog.description_length');
        if (strlen($this->content) > $maxLength);
            return substr($this->content, 0, $maxLength).'...';
        return $this->content;
    }

    public function getThumbnailAttribute()
    {
        return asset('storage/public/thumbnails/'.$this->thumbnail_path);
    }

    public function isVisible()
    {
        return $this->is_visible && empty($this->publish_at);
    }

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($this->post->updated_at)
            ->link(route('admin.posts.show', $this->id))
            ->author($this->author->full_name);
    }

    public static function getFeedItems()
    {
        return static::all();
    }

    public function scopeSearch($query, $searchData)
    {
        if (!empty($searchData)){
            $searchData = trim($searchData);
            $queries = explode(' ', $searchData);
            foreach ($queries as $q){
                $query->where('title', 'like', '%'.$q.'%')
                ->OrWhere('content', 'like', '%'.$q.'%');
            }
        }
        return $query;
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', 1)->whereNull('publish_at');
    }

    public function scopeNotVisible($query)
    {
        return $query->where('is_visible', 0)->orWhereNotNull('publish_at');
    }
}
