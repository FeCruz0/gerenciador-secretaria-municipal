<?php

namespace Database\Seeders;

use App\Models\HomeModule;
use Illuminate\Database\Seeder;

class HomeModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'name' => 'carousel_banners',
                'title' => 'Banner Rotativo',
                'is_enabled' => true,
                'order' => 1,
            ],
            [
                'name' => 'shortcuts',
                'title' => 'Atalhos Rápidos',
                'is_enabled' => true,
                'order' => 2,
            ],
            [
                'name' => 'news',
                'title' => 'Últimas Notícias',
                'is_enabled' => true,
                'order' => 3,
            ],
            [
                'name' => 'contact_info',
                'title' => 'Canais de Comunicação',
                'is_enabled' => true,
                'order' => 4,
            ],
        ];

        foreach ($modules as $module) {
            HomeModule::updateOrCreate(
                ['name' => $module['name']],
                [
                    'title' => $module['title'],
                    'is_enabled' => $module['is_enabled'],
                    'order' => $module['order'],
                ]
            );
        }
    }
}
