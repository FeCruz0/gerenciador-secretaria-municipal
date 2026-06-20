<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Enums\Permission as PermissionEnum;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Garante a existência dos papéis padrão
        $devRole = Role::firstOrCreate(['name' => 'Desenvolvedor', 'guard_name' => 'web']);
        $adminMasterRole = Role::firstOrCreate(['name' => 'Administrador Master', 'guard_name' => 'web']);

        // Percorre todas as permissões do Enum e cria no banco
        foreach (PermissionEnum::cases() as $permissionCase) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionCase->value,
                'guard_name' => 'web'
            ]);

            // Associa aos papéis padrão caso não possuam
            if (!$devRole->hasPermissionTo($permission)) {
                $devRole->givePermissionTo($permission);
            }
            if (!$adminMasterRole->hasPermissionTo($permission)) {
                $adminMasterRole->givePermissionTo($permission);
            }
        }
    }
}
