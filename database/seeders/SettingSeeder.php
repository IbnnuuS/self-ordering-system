<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'store_name'     => 'Self Ordering System',
            'store_address'  => 'Jl. Contoh No. 123, Kota',
            'store_phone'    => '0812-3456-7890',
            'wifi_ssid'      => 'SelfOrder_WiFi',
            'wifi_password'  => 'welcome123',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
