<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TimezoneController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
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
            'timezone' => $request->timezone,
        ]);

        return back()->with('success', 'Timezone updated successfully.');
    }
}