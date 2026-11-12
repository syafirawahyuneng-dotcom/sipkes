<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class LogoSeeder extends Seeder
{
    public function run(): void
    {
        $tempPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sipkes_logo_b64.txt';
        if (file_exists($tempPath)) {
            $base64 = trim(file_get_contents($tempPath));
            SiteSetting::set('site_logo', 'data:image/png;base64,' . $base64);
        }
    }
}

