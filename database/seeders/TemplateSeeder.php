<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::updateOrCreate(
            ['name' => 'Default Minimalist Border'],
            [
                'background_path' => null,
                'is_default' => true,
            ]
        );

        Template::updateOrCreate(
            ['name' => 'Professional Certificate'],
            [
                'background_path' => 'templates/professional.jpg',
                'is_default' => false,
            ]
        );
    }
}
