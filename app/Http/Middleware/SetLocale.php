<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Reads locale from session, falls back to cookie, defaults to 'id'.
     * Only allows 'id' and 'en' as valid locales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', $request->cookie('locale', 'id'));

        if (!in_array($locale, ['id', 'en'])) {
            $locale = 'id';
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
