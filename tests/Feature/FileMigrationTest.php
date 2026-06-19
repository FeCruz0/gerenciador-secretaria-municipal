<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\File;
use App\Models\Unit;
use App\Models\Organization;
use App\Models\Legislation;
use App\Models\LegislationCategory;
use App\Models\LegislationSituation;
use App\Models\FileLegislation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class FileMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });

        // Configuração de Organização e Unidade
        $org = Organization::create(['title' => 'Org', 'active' => 1]);
        Unit::create([
            'name'            => 'Secretaria de Saúde',
            'sigla'           => 'SESAU',
            'phone'           => '12345678',
            'web'             => true,
            'city_id'         => 1,
            'organization_id' => $org->id,
        ]);
    }

    private function createLegislation(): Legislation
    {
        $category = LegislationCategory::create(['category' => 'Categoria de Teste', 'active' => 1]);
        $situation = LegislationSituation::create(['situation' => 'Situação de Teste', 'active' => 1]);

        return Legislation::create([
            'category_id'       => $category->id,
            'situation_id'      => $situation->id,
            'ementa'            => 'Ementa de teste para legislação',
            'number'            => 1234,
            'number_complement' => '',
            'date'              => '2026-06-19',
            'information'       => '',
            'excerpt'           => '',
            'body'              => '',
            'meta_description'  => '',
            'active'            => 1,
        ]);
    }

    public function test_can_view_file_show_administrative()
    {
        $user = User::factory()->create();
        $file = File::create([
            'file_type_id' => 1,
            'title'        => 'Documento Importante',
            'url'          => 'documents/importante.pdf',
        ]);

        $response = $this->actingAs($user)->get("/arquivos/{$file->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('File/Show'));
    }

    public function test_file_web_public_remains_blade()
    {
        $user = User::factory()->create();
        $file = File::create([
            'file_type_id' => 1,
            'title'        => 'Documento Web',
            'url'          => 'documents/web.pdf',
        ]);

        $response = $this->actingAs($user)->get("/file_web/{$file->id}");

        $response->assertStatus(200);
        $response->assertViewIs('web.file.show');
        $response->assertViewHas('file');
    }

    public function test_can_update_file_title()
    {
        $user = User::factory()->create();
        $file = File::create([
            'file_type_id' => 1,
            'title'        => 'Titulo Antigo',
            'url'          => 'documents/teste.pdf',
        ]);

        $response = $this->actingAs($user)
            ->from("/arquivos/{$file->id}")
            ->put("/arquivos/{$file->id}", [
                'title' => 'Titulo Novo',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('files', [
            'id'    => $file->id,
            'title' => 'Titulo Novo',
        ]);
    }

    public function test_can_destroy_file()
    {
        $user = User::factory()->create();
        $file = File::create([
            'file_type_id' => 1,
            'title'        => 'Arquivo a Deletar',
            'url'          => 'documents/deletar.pdf',
        ]);

        // Cria legislação e associa com o arquivo
        $legislation = $this->createLegislation();
        FileLegislation::create([
            'legislation_id' => $legislation->id,
            'file_id'        => $file->id,
        ]);

        // Garante que o arquivo físico existe no local esperado para o unlink não falhar
        $physicalPath = storage_path('app/public/files/documents/deletar.pdf');
        @mkdir(dirname($physicalPath), 0777, true);
        file_put_contents($physicalPath, 'pdf content dummy');

        $response = $this->actingAs($user)->delete("/arquivos/{$file->id}");

        // Deve redirecionar para a tela da legislação associada
        $response->assertRedirect();
        $this->assertSoftDeleted('files', [
            'id' => $file->id,
        ]);
        
        // Garante que o arquivo físico foi removido
        $this->assertFileDoesNotExist($physicalPath);
    }
}
