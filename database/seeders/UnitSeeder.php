<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Configurar a unidade padrão para o município do projeto
        // DB::table('units')->insert([
        //     'name' => 'Nome da Unidade',
        //     'sigla' => 'SIGLA',
        //     'city_id' => 0, // ID da cidade no banco
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
