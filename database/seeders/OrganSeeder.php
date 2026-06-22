<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gesem = \App\Models\Organ::firstOrCreate(
            ['slug' => 'gesem'],
            [
                'name' => 'Secretaria de Meio Ambiente e Saneamento',
                'sigla' => 'GESEM',
                'theme_color_hex' => '#10b981',
                'logo_path' => 'gesem-logo.svg',
                'is_active' => true,
            ]
        );

        $educ = \App\Models\Organ::firstOrCreate(
            ['slug' => 'educ'],
            [
                'name' => 'Secretaria de Educação',
                'sigla' => 'EDUC',
                'theme_color_hex' => '#3b82f6',
                'logo_path' => 'educ-logo.svg',
                'is_active' => true,
            ]
        );

        $tables = [
            'users',
            'news',
            'biddings',
            'banners',
            'faqs',
            'shortcut_webs',
            'home_modules',
            'departaments'
        ];

        foreach ($tables as $tableName) {
            if (\Illuminate\Support\Facades\Schema::hasTable($tableName)) {
                \Illuminate\Support\Facades\DB::table($tableName)
                    ->whereNull('organ_id')
                    ->update(['organ_id' => $gesem->id]);
            }
        }
    }
}
