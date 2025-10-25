<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Fillable fields
    protected $fillable = ['key', 'value'];

    // Gunakan timestamps
    public $timestamps = true;

    /**
     * Ambil value berdasarkan key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    
    /**
     * Set atau update value berdasarkan key
     *
     * @param string $key
     * @param mixed $value
     * @return Setting
     */
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Ambil semua setting default atau buat jika belum ada
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDefaultSettings()
    {
        $defaults = [
            'app_name' => 'Stockify',
            'company_name' => 'Stockify Company',
            'email' => 'admin@stockify.com',
            'phone' => '',
            'address' => '',
            'logo' => 'logos/logo.jpg'
        ];

        // Cek jika tidak ada, buat default
        foreach ($defaults as $key => $value) {
            static::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        return static::all();
    }
}
