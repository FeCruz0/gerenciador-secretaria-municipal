<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

class RolesAdministrationTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic permissions using findOrCreate to avoid duplication issues
        Permission::findOrCreate('Ver e Listar Regras', 'web');
        Permission::findOrCreate('Criar Regras', 'web');
        Permission::findOrCreate('Editar Regras', 'web');
        Permission::findOrCreate('Deletar Regras', 'web');

        $role = Role::findOrCreate('Administrador', 'web');
        $role->syncPermissions(['Ver e Listar Regras', 'Criar Regras', 'Editar Regras', 'Deletar Regras']);

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole($role);
    }

    public function test_authorized_user_can_view_roles_index()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('roles.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Roles/Index')
            ->has('roles')
        );
    }

    public function test_authorized_user_can_create_role()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('roles.store'), [
                'name' => 'Novo Perfil de Teste',
                'permissions' => ['Ver e Listar Regras']
            ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'Novo Perfil de Teste']);
    }

    public function test_authorized_user_can_edit_role()
    {
        $role = Role::create(['name' => 'Role a Editar', 'guard_name' => 'web']);

        $response = $this->actingAs($this->adminUser)
            ->put(route('roles.update', $role->id), [
                'name' => 'Role Editada',
                'permissions' => ['Ver e Listar Regras', 'Editar Regras']
            ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'Role Editada']);
    }

    public function test_role_cannot_be_deleted_if_has_users()
    {
        $role = Role::create(['name' => 'Role com User', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('roles.destroy', $role->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'Role com User']);
    }
}
