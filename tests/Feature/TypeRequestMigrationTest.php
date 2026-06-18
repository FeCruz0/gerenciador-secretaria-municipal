<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TypeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class TypeRequestMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    public function test_admin_can_view_request_type_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/ouvidoria_requisicoes');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Ombudsman/RequestIndex'));
    }

    public function test_admin_can_store_request_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/ouvidoria_requisicoes', [
            'title' => 'Reclamação',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('type_requests', [
            'title' => 'Reclamação',
            'slug' => 'reclamacao',
        ]);
    }

    public function test_store_validates_required_title()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/ouvidoria_requisicoes', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_admin_can_view_request_type_show()
    {
        $user = User::factory()->create();

        $type = TypeRequest::create(['title' => 'Sugestão']);

        $response = $this->actingAs($user)->get("/ouvidoria_requisicoes/{$type->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Ombudsman/RequestIndex'));
    }

    public function test_admin_can_update_request_type()
    {
        $user = User::factory()->create();

        $type = TypeRequest::create(['title' => 'Elogio Original']);

        $response = $this->actingAs($user)->put("/ouvidoria_requisicoes/{$type->id}", [
            'title' => 'Elogio Atualizado',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('type_requests', [
            'id'    => $type->id,
            'title' => 'Elogio Atualizado',
            'slug' => 'elogio-atualizado',
        ]);
    }

    public function test_admin_can_delete_request_type()
    {
        $user = User::factory()->create();

        $type = TypeRequest::create(['title' => 'Solicitação Para Deletar']);

        $response = $this->actingAs($user)->delete("/ouvidoria_requisicoes/{$type->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('type_requests', [
            'id' => $type->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_request_types()
    {
        $response = $this->get('/ouvidoria_requisicoes');

        $response->assertRedirect('/login');
    }
}
