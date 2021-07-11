<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class SetLangInAdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('lang')){
            $lang = Cookie::get('lang');
            foreach (config('blog.available_locales') as $locale){
                if ($locale == $lang)
                    app()->setLocale(Cookie::get('lang'));
            }
        }
        return $next($request);
    }

    static public function setLang($lang)
    {
        Cookie::queue('lang', $lang);
        app()->setLocale($lang);
    }
}
