<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class SetLang
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
        foreach (config('app.available_locales') as $locale){
            if ($locale == $request->segment(1)){
                Cookie::queue('lang', $request->segment(1));
                app()->setLocale($request->segment(1));
                return $next($request);
            }
        }
        abort(404);
    }
}
