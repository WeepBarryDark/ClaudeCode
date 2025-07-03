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
            
            // Debug log
            \Log::info('Setting user locale', [
                'user_id' => $user->id,
                'user_locale' => $user->locale,
                'current_app_locale' => app()->getLocale()
            ]);
            
            // Set locale
            if ($user->locale) {
                App::setLocale($user->locale);
                Session::put('locale', $user->locale);
                
                \Log::info('Locale set', [
                    'new_app_locale' => app()->getLocale()
                ]);
            }
            
            // Set timezone
            if ($user->timezone) {
                config(['app.timezone' => $user->timezone]);
                Session::put('timezone', $user->timezone);
                
                // Set Carbon timezone globally
                date_default_timezone_set($user->timezone);
            }
        } else {
            // For guests, use session stored locale/timezone if available
            if (Session::has('locale')) {
                $sessionLocale = Session::get('locale');
                App::setLocale($sessionLocale);
                
                \Log::info('Guest locale set from session', [
                    'session_locale' => $sessionLocale,
                    'current_app_locale' => app()->getLocale()
                ]);
            }
            
            if (Session::has('timezone')) {
                config(['app.timezone' => Session::get('timezone')]);
                date_default_timezone_set(Session::get('timezone'));
            }
        }

        return $next($request);
    }
}