<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class LanguageController extends Controller
{
    public function show()
    {
        return Inertia::render('settings/Language');
    }

    public function update(Request $request)
    {
        $request->validate([
            'locale' => ['required', 'string', Rule::in(['en', 'zh-CN'])],
            'timezone' => ['required', 'string', Rule::in([
                'Australia/Sydney',
                'Australia/Melbourne', 
                'Australia/Brisbane',
                'Australia/Perth',
                'Australia/Adelaide',
                'Pacific/Auckland',
                'Pacific/Chatham',
                'Asia/Shanghai',
                'Asia/Hong_Kong',
                'Asia/Macau',
            ])],
        ]);

        $user = Auth::user();
        $user->update([
            'locale' => $request->locale,
            'timezone' => $request->timezone,
        ]);

        // Set the application locale for the current request
        app()->setLocale($request->locale);

        return back()->with('success', 'Language and timezone preferences updated successfully.');
    }
}