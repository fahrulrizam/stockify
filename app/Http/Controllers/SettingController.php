<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan aplikasi
     */
    public function index()
    {
        // Ambil semua setting yang diperlukan sekaligus
        $settings = Setting::whereIn('key', ['app_name', 'company_name'])
            ->pluck('value', 'key')
            ->toArray();

        // Default jika belum ada di database
        $app_name = $settings['app_name'] ?? 'Stockify';
        $company_name = $settings['company_name'] ?? 'Perusahaan';

        return view('settings.index', compact('app_name', 'company_name'));
    }

    /**
     * Update pengaturan aplikasi
     */
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'app_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);

        // Simpan atau update setting
        Setting::updateOrCreate(
            ['key' => 'app_name'],
            ['value' => $request->app_name]
        );

        Setting::updateOrCreate(
            ['key' => 'company_name'],
            ['value' => $request->company_name]
        );

        // Redirect kembali dengan pesan sukses
        return redirect()->route('settings.index')
                         ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
