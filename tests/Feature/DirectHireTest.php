<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DirectHire;
use App\Models\DirectHireModality;
use App\Models\DirectHireSituations;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class DirectHireTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Define as permissões para o Gate
        Gate::before(function () {
            return true;
        });

        // Criar uma organização e unidade padrão requeridas pelos controllers
        $org = \App\Models\Organization::create([
            'title' => 'Prefeitura de Teste',
            'active' => 1,
        ]);

        Unit::create([
            'name' => 'Secretaria Teste',
            'sigla' => 'SEC',
            'phone' => '12345678',
            'web' => true,
            'organization_id' => $org->id,
        ]);
    }

    public function test_admin_can_view_direct_hires_list()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/contratacoes_diretas');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_create_direct_hire_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/contratacoes_diretas/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_show_direct_hire_page()
    {
        $user = User::factory()->create();
        $modality = DirectHireModality::create(['title' => 'Dispensa']);
        $situation = DirectHireSituations::create(['title' => 'Em andamento']);
        
        $directHire = DirectHire::create([
            'title' => 'Compra de Equipamentos',
            'modality_id' => $modality->id,
            'situation_id' => $situation->id,
            'bidding' => '001/2026',
            'status' => 'PUBLISHED',
            'login' => 0,
            'value_min' => 1000.00,
            'value_max' => 5000.00,
            'local' => 'Secretaria',
            'content' => 'Objeto de teste',
            'process' => '2026/001',
            'published_at' => now(),
            'realized_at' => now(),
        ]);

        $response = $this->actingAs($user)->get("/contratacoes_diretas/{$directHire->id}");

        $response->assertStatus(200);
    }
}
