<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingSeeder::class,
            TemplateSeeder::class,
        ]);

        // Cari template default
        $template = \App\Models\Template::where('is_default', true)->first();

        // Buat sertifikat dummy untuk mempermudah testing
        \App\Models\Certificate::updateOrCreate(
            ['code' => 'SK-2026-8HJ27X'],
            [
                'nomor_sertifikat' => '001/EKS/2026',
                'nama_siswa' => 'Aurel Calista',
                'nis' => '2026102391',
                'sekolah' => 'SMK Negeri 1 Cirebon',
                'kelas' => 'XII RPL 1',
                'ekskul' => 'Pramuka Garuda',
                'jenis_sertifikat' => 'Sertifikat Kejuaraan',
                'prestasi' => 'Juara 1 Lomba Tingkat Kota',
                'tanggal' => '2026-07-30',
                'nama_pembina' => 'Budi Santoso, S.Pd.',
                'jabatan_pembina' => 'Pembina Pramuka',
                'template_id' => $template ? $template->id : null,
                'logo_sekolah' => 'logos/logo-rakitai.png',
                'status' => 'Aktif',
            ]
        );
    }
}
