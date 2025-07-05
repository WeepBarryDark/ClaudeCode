<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SetUserLocaleAndTimezone
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Set locale
            if ($user->locale) {
                App::setLocale($user->locale);
                Session::put('locale', $user->locale);
            }
            
            // Set timezone
            if ($user->timezone) {
                config(['app.timezone' => $user->timezone]);
                Session::put('timezone', $user->timezone);
                date_default_timezone_set($user->timezone);
            }
        } else {
            // For guests, use session stored locale/timezone if available
            if (Session::has('locale')) {
                $sessionLocale = Session::get('locale');
                App::setLocale($sessionLocale);
            }
            
            if (Session::has('timezone')) {
                config(['app.timezone' => Session::get('timezone')]);
                date_default_timezone_set(Session::get('timezone'));
            }
        }

        return $next($request);
    }
}