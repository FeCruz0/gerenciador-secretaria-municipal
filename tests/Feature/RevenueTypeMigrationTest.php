<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\RevenueType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RevenueTypeMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    public function test_admin_can_view_revenue_type_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/receita_tipos');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Revenue/TypeIndex'));
    }

    public function test_admin_can_store_revenue_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/receita_tipos', [
            'title' => 'Receita Tributária',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('revenue_types', [
            'title' => 'Receita Tributária',
        ]);
    }

    public function test_store_validates_required_title()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/receita_tipos', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_admin_can_view_revenue_type_show()
    {
        $user = User::factory()->create();

        $type = RevenueType::create(['title' => 'Receita Corrente']);

        $response = $this->actingAs($user)->get("/receita_tipos/{$type->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Revenue/TypeIndex'));
    }

    public function test_admin_can_update_revenue_type()
    {
        $user = User::factory()->create();

        $type = RevenueType::create(['title' => 'Receita Original']);

        $response = $this->actingAs($user)->put("/receita_tipos/{$type->id}", [
            'title' => 'Receita Atualizada',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('revenue_types', [
            'id'    => $type->id,
            'title' => 'Receita Atualizada',
        ]);
    }

    public function test_admin_can_delete_revenue_type()
    {
        $user = User::factory()->create();

        $type = RevenueType::create(['title' => 'Receita Para Deletar']);

        $response = $this->actingAs($user)->delete("/receita_tipos/{$type->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('revenue_types', [
            'id' => $type->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_revenue_types()
    {
        $response = $this->get('/receita_tipos');

        $response->assertRedirect('/login');
    }
}
