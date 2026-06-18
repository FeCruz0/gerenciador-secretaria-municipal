<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ConservationUnit;
use App\Models\ConservationUnitType;
use App\Models\Coverage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class ConservationUnitMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createDependencies()
    {
        $type = ConservationUnitType::create(['type' => 'Parque Municipal']);
        $coverage = Coverage::create(['city' => 'Mata Atlântica']);

        return [$type, $coverage];
    }

    public function test_admin_can_view_conservation_unit_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/unid_conservacao');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ConservationUnit/Index'));
    }

    public function test_admin_can_view_conservation_unit_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/unid_conservacao/create');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ConservationUnit/Create'));
    }

    public function test_admin_can_store_conservation_unit()
    {
        $user = User::factory()->create();
        [$type, $coverage] = $this->createDependencies();

        $response = $this->actingAs($user)->post('/unid_conservacao', [
            'title' => 'Parque Ecológico',
            'conservation_unit_type_id' => $type->id,
            'creation' => 'Decreto 123',
            'creation_link' => 'http://exemplo.com',
            'objective' => 'Preservar fauna',
            'area' => '500 ha',
            'localization' => 'Coordenadas X,Y',
            'address' => 'Estrada do Parque, 100',
            'phone' => '1199999999',
            'email' => 'parque@exemplo.com',
            'opening_hours' => '08:00 - 17:00',
            'status' => 'PUBLISHED',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('conservation_units', [
            'title' => 'Parque Ecológico',
            'conservation_unit_type_id' => $type->id,
        ]);
    }

    public function test_admin_can_view_conservation_unit_show()
    {
        $user = User::factory()->create();
        [$type, $coverage] = $this->createDependencies();

        $conservationUnit = ConservationUnit::create([
            'title' => 'Parque Ecológico',
            'conservation_unit_type_id' => $type->id,
            'creation' => 'Decreto 123',
            'creation_link' => 'http://exemplo.com',
            'objective' => 'Preservar fauna',
            'area' => '500 ha',
            'localization' => 'Coordenadas X,Y',
            'address' => 'Estrada do Parque, 100',
            'phone' => '1199999999',
            'email' => 'parque@exemplo.com',
            'opening_hours' => '08:00 - 17:00',
            'status' => 'PUBLISHED',
        ]);

        $response = $this->actingAs($user)->get("/unid_conservacao/{$conservationUnit->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ConservationUnit/Show'));
    }

    public function test_admin_can_update_conservation_unit()
    {
        $user = User::factory()->create();
        [$type, $coverage] = $this->createDependencies();

        $conservationUnit = ConservationUnit::create([
            'title' => 'Parque Ecológico',
            'conservation_unit_type_id' => $type->id,
            'creation' => 'Decreto 123',
            'creation_link' => 'http://exemplo.com',
            'objective' => 'Preservar fauna',
            'area' => '500 ha',
            'localization' => 'Coordenadas X,Y',
            'address' => 'Estrada do Parque, 100',
            'phone' => '1199999999',
            'email' => 'parque@exemplo.com',
            'opening_hours' => '08:00 - 17:00',
            'status' => 'PUBLISHED',
        ]);

        $response = $this->actingAs($user)->put("/unid_conservacao/{$conservationUnit->id}", [
            'title' => 'Parque Ecológico Atualizado',
            'conservation_unit_type_id' => $type->id,
            'creation' => 'Decreto 123',
            'creation_link' => 'http://exemplo.com',
            'objective' => 'Preservar fauna',
            'area' => '500 ha',
            'localization' => 'Coordenadas X,Y',
            'address' => 'Estrada do Parque, 100',
            'phone' => '1199999999',
            'email' => 'parque@exemplo.com',
            'opening_hours' => '08:00 - 17:00',
            'status' => 'PUBLISHED',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('conservation_units', [
            'id' => $conservationUnit->id,
            'title' => 'Parque Ecológico Atualizado',
        ]);
    }

    public function test_admin_can_delete_conservation_unit()
    {
        $user = User::factory()->create();
        [$type, $coverage] = $this->createDependencies();

        $conservationUnit = ConservationUnit::create([
            'title' => 'Parque Ecológico',
            'conservation_unit_type_id' => $type->id,
            'creation' => 'Decreto 123',
            'creation_link' => 'http://exemplo.com',
            'objective' => 'Preservar fauna',
            'area' => '500 ha',
            'localization' => 'Coordenadas X,Y',
            'address' => 'Estrada do Parque, 100',
            'phone' => '1199999999',
            'email' => 'parque@exemplo.com',
            'opening_hours' => '08:00 - 17:00',
            'status' => 'PUBLISHED',
        ]);

        $response = $this->actingAs($user)->delete("/unid_conservacao/{$conservationUnit->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('conservation_units', [
            'id' => $conservationUnit->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_conservation_units()
    {
        $response = $this->get('/unid_conservacao');

        $response->assertRedirect('/login');
    }
}
