<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TypeAccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class TypeAccessMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Bypass permissions by default, but we can override in tests if needed
        Gate::before(function () {
            return true;
        });
    }

    public function test_admin_can_view_access_type_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/ouvidoria_acessos');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Ombudsman/AccessIndex'));
    }

    public function test_admin_can_store_access_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/ouvidoria_acessos', [
            'title' => 'Acesso Identificado',
            'anonymous' => 0,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('type_accesses', [
            'title' => 'Acesso Identificado',
            'anonymous' => 0,
            'slug' => 'acesso-identificado',
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/ouvidoria_acessos', [
            'title' => '',
            'anonymous' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'anonymous']);
    }

    public function test_admin_can_view_access_type_show()
    {
        $user = User::factory()->create();

        $type = TypeAccess::create([
            'title' => 'Acesso Anônimo',
            'anonymous' => 1,
        ]);

        $response = $this->actingAs($user)->get("/ouvidoria_acessos/{$type->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Ombudsman/AccessIndex'));
    }

    public function test_admin_can_update_access_type()
    {
        $user = User::factory()->create();

        $type = TypeAccess::create([
            'title' => 'Acesso Original',
            'anonymous' => 0,
        ]);

        $response = $this->actingAs($user)->put("/ouvidoria_acessos/{$type->id}", [
            'title' => 'Acesso Editado',
            'anonymous' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('type_accesses', [
            'id' => $type->id,
            'title' => 'Acesso Editado',
            'anonymous' => 1,
            'slug' => 'acesso-editado',
        ]);
    }

    public function test_admin_can_delete_access_type()
    {
        $user = User::factory()->create();

        $type = TypeAccess::create([
            'title' => 'Acesso Para Deletar',
            'anonymous' => 0,
        ]);

        $response = $this->actingAs($user)->delete("/ouvidoria_acessos/{$type->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('type_accesses', [
            'id' => $type->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_access_types()
    {
        $response = $this->get('/ouvidoria_acessos');

        $response->assertRedirect('/login');
    }
}
