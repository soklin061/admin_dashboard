<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        // Fetch all settings and index by key
        $settings = Setting::all()->pluck('value', 'key')->all();
        
        // Define default keys if they don't exist in DB yet
        $defaultKeys = [
            'site_name' => 'Laravel Admin Panel',
            'site_email' => 'admin@example.com',
            'maintenance_mode' => 'no',
            'allowed_registration' => 'yes'
        ];

        foreach ($defaultKeys as $key => $defaultVal) {
            if (!isset($settings[$key])) {
                $settings[$key] = $defaultVal;
            }
        }

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settingsData = $request->except('_token', '_method');

        foreach ($settingsData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->log('updated system settings');

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully.');
    }
}
