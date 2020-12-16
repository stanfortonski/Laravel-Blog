<?php

namespace App\Models;

use App\Interfaces\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Stanfortonski\Laravelroles\Traits\HasRole;
use Illuminate\Support\Str;

class User extends Authenticatable implements Searchable
{
    use HasFactory, Notifiable, HasRole, TwoFactorAuthenticatable;

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
        'description',
        'website',
        'thumbnail_path'
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

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getAvatarAttribute()
    {
        return asset('storage/public/thumbnails/'.$this->thumbnail_path);
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
        $first_last = explode('-', $url);
        if (count($first_last) == 2)
            return static::where('first_name', '=', $first_last[0])->where('last_name', '=', $first_last[1])->first();
        else abort(404);
    }

    static public function findOrFailByUrl($url)
    {
        $first_last = explode('-', $url);
        if (count($first_last) == 2)
            return static::where('first_name', '=', $first_last[0])->where('last_name', '=', $first_last[1])->firstOrFail();
        else abort(404);
    }

    public function getUrlAttribute()
    {
       return $this->first_name.'-'.$this->last_name;
    }
}
