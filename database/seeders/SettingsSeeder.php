<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('corner_price', 200, 'number', 'prices', 'Доп. углы');
        Setting::set('light_price', 300, 'number', 'prices', 'Светильники');
        Setting::set('chandelier_price', 500, 'number', 'prices', 'Люстры');
    }
}
