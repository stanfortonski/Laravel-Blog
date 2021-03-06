<?php

namespace App\Models;

use App\Interfaces\Searchable;
use App\Traits\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Stanfortonski\Laravelroles\Traits\HasRoles;

class User extends Authenticatable implements Searchable
{
    use HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

    use HasThumbnail {
        getThumbnailAttribute as getAvatarAttribute;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'password',
        'email',
        'website',
        'thumbnail_path',
        'url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function content()
    {
        return $this->hasOne(AuthorContent::class, 'author_id', 'id')->where('lang', '=', app()->getLocale());
    }

    public function contents()
    {
        return $this->hasOne(AuthorContent::class, 'author_id', 'id');
    }

    public function scopeSearch($query, $searchData)
    {
        if (!empty($searchData)){
            $searchData = trim($searchData);
            $queries = explode(' ', $searchData);

            foreach ($queries as $q){
                $query->orWhere('first_name', 'like', '%'.$q.'%')
                ->orWhere('last_name', 'like', '%'.$q.'%')
                ->orWhere('name', 'like', '%'.$q.'%');
            }
        }
        return $query;
    }

    static public function findByUrl($url)
    {
        return static::where('url', '=', $url)->first();
    }

    static public function findOrFailByUrl($url)
    {
        return static::where('url', '=', $url)->firstOrFail();
    }
}
