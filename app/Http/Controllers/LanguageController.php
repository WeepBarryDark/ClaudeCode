<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    public function update(Request $request)
    {
        \Log::info('Language update request received', [
            'requested_locale' => $request->locale,
            'current_app_locale' => app()->getLocale(),
            'authenticated' => Auth::check()
        ]);
        
        $request->validate([
            'locale' => ['required', 'string', Rule::in(['en', 'zh-CN'])],
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            $oldLocale = $user->locale;
            
            $user->update([
                'locale' => $request->locale,
            ]);
            
            $user->refresh();
            
            // Debug: Log the change
            \Log::info('Language changed', [
                'user_id' => $user->id,
                'old_locale' => $oldLocale,
                'new_locale' => $request->locale,
                'user_locale_after_update' => $user->locale,
                'database_updated' => $user->locale === $request->locale
            ]);
        } else {
            // For guests, store locale in session
            session(['locale' => $request->locale]);
            
            \Log::info('Guest language changed', [
                'new_locale' => $request->locale,
                'session_locale' => session('locale')
            ]);
        }

        // Set the application locale for the current request
        $oldAppLocale = app()->getLocale();
        app()->setLocale($request->locale);
        
        \Log::info('App locale changed', [
            'old_app_locale' => $oldAppLocale,
            'new_app_locale' => app()->getLocale(),
            'locale_changed' => app()->getLocale() === $request->locale
        ]);

        return back()->with('success', 'Language updated successfully.');
    }
}