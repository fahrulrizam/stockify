<?php

namespace App\Services;

use App\Repositories\SettingRepository;

class SettingService
{
    protected $settingRepo;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepo = $settingRepo;
    }

    public function getSettings(array $keys)
    {
        return $this->settingRepo->getByKeys($keys);
    }

    public function updateSettings(array $data)
    {
        foreach ($data as $key => $value) {
            $this->settingRepo->updateOrCreate($key, $value);
        }
    }
}
