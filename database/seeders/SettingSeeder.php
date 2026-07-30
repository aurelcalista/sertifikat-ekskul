<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'app_name' => 'Sertifikat Ekskul',
            'sekolah_default' => 'SMK Negeri 1 Cirebon',
            'pembina_default' => 'Budi Santoso, S.Pd.',
            'jabatan_pembina_default' => 'Pembina OSIS',
            'logo_default' => 'logos/logo-rakitai.png',
            'tanda_tangan_default' => null,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
