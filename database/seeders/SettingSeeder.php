<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create(['key' => 'company_name', 'value' => 'PT. RIAU WISATA HATI']);
        Setting::create(['key' => 'company_address', 'value' => 'Jl. Jendral Sudirman (Depan Bank BRI) Bangkinang Kota']);
        Setting::create(['key' => 'company_phone', 'value' => '(+628) 52.898.55555']);
        Setting::create(['key' => 'company_email', 'value' => 'info@rwh-travel.com']);
        Setting::create(['key' => 'company_logo', 'value' => 'admin/assets/img/logorwh1.png']); // Default asset path
    }
}
