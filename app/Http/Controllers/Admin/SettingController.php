<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->middleware('auth');
        $this->middleware('role:admin'); // Hanya admin bisa ubah pengaturan
        $this->settingService = $settingService;
    }

    /**
     * Tampilkan halaman pengaturan aplikasi.
     */
    public function index()
    {
        $settings = $this->settingService->getSettings(['app_name', 'company_name']);

        return view('settings.index', [
            'app_name' => $settings['app_name'] ?? 'Stockify',
            'company_name' => $settings['company_name'] ?? 'Perusahaan',
        ]);
    }

    /**
     * Update pengaturan aplikasi.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);

        $this->settingService->updateSettings($validated);

        return redirect()
            ->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
