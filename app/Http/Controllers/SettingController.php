<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name'    => 'required|string|max:100',
            'store_address' => 'required|string|max:255',
            'store_phone'   => 'required|string|max:20',
            'wifi_ssid'     => 'nullable|string|max:50',
            'wifi_password' => 'nullable|string|max:50',
        ]);

        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
