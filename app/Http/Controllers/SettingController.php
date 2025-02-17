<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    // Menyimpan perubahan pengaturan
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'admin_email' => 'required|email',
        ]);

        // Simpan atau update pengaturan
        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
