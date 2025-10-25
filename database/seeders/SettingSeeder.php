<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::create([
            'app_name' => 'Stockify',
            'company_name' => 'PT Gudang Cerdas',
            'email' => 'admin@stockify.com',
            'phone' => '081234567890',
            'address' => 'Jl. Industri No. 45, Jakarta',
        ]);
    }
}
