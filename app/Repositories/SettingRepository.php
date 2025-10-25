<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    public function getByKeys(array $keys)
    {
        return Setting::whereIn('key', $keys)
            ->pluck('value', 'key')
            ->toArray();
    }

    public function updateOrCreate(string $key, ?string $value)
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
