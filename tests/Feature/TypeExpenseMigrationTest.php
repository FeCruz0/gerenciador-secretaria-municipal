<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TypeExpense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class TypeExpenseMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    public function test_admin_can_view_expense_type_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/despesa_tipos');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Expense/TypeIndex'));
    }

    public function test_admin_can_store_expense_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/despesa_tipos', [
            'title' => 'Despesa de Pessoal',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('type_expenses', [
            'title' => 'Despesa de Pessoal',
            'slug' => 'despesa-de-pessoal',
        ]);
    }

    public function test_store_validates_required_title()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/despesa_tipos', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_admin_can_view_expense_type_show()
    {
        $user = User::factory()->create();

        $type = TypeExpense::create(['title' => 'Despesa Corrente']);

        $response = $this->actingAs($user)->get("/despesa_tipos/{$type->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Expense/TypeIndex'));
    }

    public function test_admin_can_update_expense_type()
    {
        $user = User::factory()->create();

        $type = TypeExpense::create(['title' => 'Despesa Original']);

        $response = $this->actingAs($user)->put("/despesa_tipos/{$type->id}", [
            'title' => 'Despesa Atualizada',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('type_expenses', [
            'id'    => $type->id,
            'title' => 'Despesa Atualizada',
            'slug' => 'despesa-atualizada',
        ]);
    }

    public function test_admin_can_delete_expense_type()
    {
        $user = User::factory()->create();

        $type = TypeExpense::create(['title' => 'Despesa Para Deletar']);

        $response = $this->actingAs($user)->delete("/despesa_tipos/{$type->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('type_expenses', [
            'id' => $type->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_expense_types()
    {
        $response = $this->get('/despesa_tipos');

        $response->assertRedirect('/login');
    }
}
