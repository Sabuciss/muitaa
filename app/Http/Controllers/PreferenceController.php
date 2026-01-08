<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    private const DEFAULTS = [
        'can_view_documents' => true,
        'can_view_inspections' => true,
        'can_view_vehicles' => true,
        'can_view_cases' => true
    ];

    public function update(Request $request)
    {
        $preferences = [];

        foreach (self::DEFAULTS as $key => $defaultValue) {
            $preferences[$key] = (bool)$request->get($key, $defaultValue);
        }

        session(['user_preferences' => $preferences]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'preferences' => $preferences]);
        }

        return redirect('dashboard')->with('status', 'Preferences updated.');
    }

    public function getPreferences()
    {
        $preferences = session('user_preferences', self::DEFAULTS);
        return response()->json($preferences);
    }
}
