<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });

        $org = Organization::create([
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

    public function test_admin_can_view_projects_list()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/projetos');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_create_project_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/projetos/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_show_project_page()
    {
        $user = User::factory()->create();
        $category = ProjectCategory::create([
            'title' => 'Obras',
            'slug' => 'obras',
            'description' => 'Descrição da categoria de teste',
            'active' => 1
        ]);

        $project = Project::create([
            'title' => 'Nova Quadra Esportiva',
            'category_id' => $category->id,
            'status' => 'PUBLISHED',
            'excerpt' => 'Resumo do projeto',
            'body' => 'Corpo do projeto',
            'meta_description' => 'Meta descrição'
        ]);

        $response = $this->actingAs($user)->get("/projetos/{$project->id}");

        $response->assertStatus(200);
    }

    public function test_admin_can_view_project_categories_list()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/projeto_categorias');

        $response->assertStatus(200);
    }
}
