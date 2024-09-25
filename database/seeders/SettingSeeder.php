<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = config("settings.content");

        foreach ($settings as $key => $value) {
            Setting::setForNew($key, $value);
        }

        Setting::clearCache();
    }
}
