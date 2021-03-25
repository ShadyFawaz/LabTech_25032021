<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class changeLocale
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
        $locale = Session::get('locale');
        if($locale){
            app()->setLocale($locale);
        }else{
            app()->setLocale('en');
        }
        return $next($request);
    }
}
