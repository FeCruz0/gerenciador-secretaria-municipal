<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Departament;
use App\Models\Occupation;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class OccupationMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createDepartament()
    {
        $org = Organization::create(['title' => 'Org', 'active' => 1]);
        $unit = Unit::create([
            'name' => 'Secretaria de Saúde',
            'sigla' => 'SESAU',
            'phone' => '12345678',
            'web' => true,
            'city_id' => 1,
            'organization_id' => $org->id,
        ]);
        return Departament::create([
            'departament' => 'Recursos Humanos',
            'sigla' => 'RH',
            'unit_id' => $unit->id,
        ]);
    }

    public function test_admin_can_view_occupation_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/ocupacoes');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Occupation/Index'));
    }

    public function test_admin_can_store_occupation()
    {
        $user = User::factory()->create();
        $dep = $this->createDepartament();

        $response = $this->actingAs($user)->post('/ocupacoes', [
            'title' => 'Diretor',
            'departament_id' => $dep->id,
            'active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('occupations', [
            'title' => 'Diretor',
            'departament_id' => $dep->id,
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/ocupacoes', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_admin_can_view_occupation_show()
    {
        $user = User::factory()->create();
        $dep = $this->createDepartament();
        $occupation = Occupation::create([
            'title' => 'Diretor',
            'departament_id' => $dep->id,
            'active' => 1,
        ]);

        $response = $this->actingAs($user)->get("/ocupacoes/{$occupation->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Occupation/Index'));
    }

    public function test_admin_can_update_occupation()
    {
        $user = User::factory()->create();
        $dep = $this->createDepartament();
        $occupation = Occupation::create([
            'title' => 'Diretor',
            'departament_id' => $dep->id,
            'active' => 1,
        ]);

        $response = $this->actingAs($user)->put("/ocupacoes/{$occupation->id}", [
            'title' => 'Diretor Geral',
            'departament_id' => $dep->id,
            'active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('occupations', [
            'id' => $occupation->id,
            'title' => 'Diretor Geral',
        ]);
    }

    public function test_admin_can_delete_occupation()
    {
        $user = User::factory()->create();
        $dep = $this->createDepartament();
        $occupation = Occupation::create([
            'title' => 'Assessor',
            'departament_id' => $dep->id,
            'active' => 1,
        ]);

        $response = $this->actingAs($user)->delete("/ocupacoes/{$occupation->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('occupations', [
            'id' => $occupation->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_occupations()
    {
        $response = $this->get('/ocupacoes');

        $response->assertRedirect('/login');
    }
}
