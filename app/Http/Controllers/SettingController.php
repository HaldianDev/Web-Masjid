<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $profile = [
            'masjid_name' => Setting::getValue('masjid_name'),
            'masjid_address' => Setting::getValue('masjid_address'),
            'masjid_history' => Setting::getValue('masjid_history'),
            'masjid_vision' => Setting::getValue('masjid_vision'),
            'masjid_mission' => Setting::getValue('masjid_mission'),
            'masjid_facilities' => Setting::getValue('masjid_facilities'),
            'masjid_legalities' => Setting::getValue('masjid_legalities'),
            'masjid_structure' => Setting::getValue('masjid_structure'),
        ];

        return view('admin.settings.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'masjid_name' => 'required|string|max:255',
            'masjid_address' => 'required|string',
            'masjid_history' => 'required|string',
            'masjid_vision' => 'required|string',
            'masjid_mission' => 'required|string',
            'masjid_facilities' => 'required|string',
            'masjid_legalities' => 'required|string',
            'masjid_structure' => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Profil masjid berhasil diperbarui.');
    }
}
