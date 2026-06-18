<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Organization;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class OrganizationMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createUnitWithOrganization()
    {
        $org = Organization::create(['title' => 'Org Principal', 'active' => 1]);
        Unit::create([
            'name' => 'Secretaria Geral',
            'sigla' => 'SG',
            'phone' => '12345678',
            'web' => true,
            'city_id' => 1,
            'organization_id' => $org->id,
        ]);
        return $org;
    }

    public function test_admin_can_view_organization_index()
    {
        $user = User::factory()->create();
        $this->createUnitWithOrganization();

        $response = $this->actingAs($user)->get('/organizacoes');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Organization/Index'));
    }

    public function test_admin_can_store_organization()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/organizacoes', [
            'title'  => 'Nova Organização',
            'active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('organizations', [
            'title'  => 'Nova Organização',
            'active' => 1,
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/organizacoes', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_admin_can_view_organization_show()
    {
        $user = User::factory()->create();
        $org = $this->createUnitWithOrganization();

        $response = $this->actingAs($user)->get("/organizacoes/{$org->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Organization/Index'));
    }

    public function test_admin_can_update_organization()
    {
        $user = User::factory()->create();
        $org = $this->createUnitWithOrganization();

        $response = $this->actingAs($user)->put("/organizacoes/{$org->id}", [
            'title'  => 'Organização Atualizada',
            'active' => 0,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('organizations', [
            'id'     => $org->id,
            'title'  => 'Organização Atualizada',
            'active' => 0,
        ]);
    }

    public function test_admin_can_delete_organization()
    {
        $user = User::factory()->create();
        $org = $this->createUnitWithOrganization();

        $response = $this->actingAs($user)->delete("/organizacoes/{$org->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('organizations', [
            'id' => $org->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_organizations()
    {
        $response = $this->get('/organizacoes');

        $response->assertRedirect('/login');
    }
}
