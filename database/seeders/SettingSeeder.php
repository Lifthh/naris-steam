<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'store_name', 'value' => 'NARIS STEAM'],
            ['key' => 'store_address', 'value' => 'Jl. Contoh Alamat No. 123'],
            ['key' => 'store_phone', 'value' => '081234567890'],
            ['key' => 'store_email', 'value' => 'info@narissteam.com'],
            ['key' => 'receipt_footer', 'value' => 'Terima kasih telah menggunakan jasa kami!'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}