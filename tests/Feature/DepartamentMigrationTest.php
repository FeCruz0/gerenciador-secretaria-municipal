<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Departament;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class DepartamentMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createUnit()
    {
        $org = Organization::create(['title' => 'Org', 'active' => 1]);
        return Unit::create([
            'name' => 'Secretaria de Saúde',
            'sigla' => 'SESAU',
            'phone' => '12345678',
            'web' => true,
            'city_id' => 1,
            'organization_id' => $org->id,
        ]);
    }

    public function test_admin_can_view_departament_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/departamentos');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Department/Index'));
    }

    public function test_admin_can_store_departament()
    {
        $user = User::factory()->create();
        $unit = $this->createUnit();

        $response = $this->actingAs($user)->post('/departamentos', [
            'departament' => 'Recursos Humanos',
            'sigla' => 'RH',
            'unit_id' => $unit->id,
            'code' => 'RH-01',
            'responsible' => 'João Silva',
            'phone' => '1199999999',
            'email' => 'rh@exemplo.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('departaments', [
            'departament' => 'RECURSOS HUMANOS', // mutator converte para maiúsculas
            'sigla' => 'RH',
            'unit_id' => $unit->id,
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/departamentos', [
            'departament' => '',
            'sigla' => '',
            'unit_id' => 9999, // inexistente
        ]);

        $response->assertSessionHasErrors(['departament', 'sigla', 'unit_id']);
    }

    public function test_admin_can_view_departament_show()
    {
        $user = User::factory()->create();
        $unit = $this->createUnit();
        $departament = Departament::create([
            'departament' => 'Financeiro',
            'sigla' => 'FIN',
            'unit_id' => $unit->id,
            'code' => 'FIN-02',
            'responsible' => 'Maria Souza',
            'phone' => '1188888888',
            'email' => 'fin@exemplo.com',
        ]);

        $response = $this->actingAs($user)->get("/departamentos/{$departament->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Department/Index'));
    }

    public function test_admin_can_update_departament()
    {
        $user = User::factory()->create();
        $unit = $this->createUnit();
        $departament = Departament::create([
            'departament' => 'Financeiro',
            'sigla' => 'FIN',
            'unit_id' => $unit->id,
            'code' => 'FIN-02',
            'responsible' => 'Maria Souza',
            'phone' => '1188888888',
            'email' => 'fin@exemplo.com',
        ]);

        $response = $this->actingAs($user)->put("/departamentos/{$departament->id}", [
            'departament' => 'Financeiro Atualizado',
            'sigla' => 'FINA',
            'unit_id' => $unit->id,
            'code' => 'FIN-02',
            'responsible' => 'Maria Souza',
            'phone' => '1188888888',
            'email' => 'fin@exemplo.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('departaments', [
            'id' => $departament->id,
            'departament' => 'FINANCEIRO ATUALIZADO',
            'sigla' => 'FINA',
        ]);
    }

    public function test_admin_can_delete_departament()
    {
        $user = User::factory()->create();
        $unit = $this->createUnit();
        $departament = Departament::create([
            'departament' => 'Logística',
            'sigla' => 'LOG',
            'unit_id' => $unit->id,
            'code' => 'LOG-03',
            'responsible' => 'Carlos Lima',
            'phone' => '1177777777',
            'email' => 'log@exemplo.com',
        ]);

        $response = $this->actingAs($user)->delete("/departamentos/{$departament->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('departaments', [
            'id' => $departament->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_departaments()
    {
        $response = $this->get('/departamentos');

        $response->assertRedirect('/login');
    }
}
