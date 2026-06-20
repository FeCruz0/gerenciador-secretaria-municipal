<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ManagementReport;
use App\Models\ManagementReportType;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class ManagementReportMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ignorar permissões nos testes administrativos
        Gate::before(function () {
            return true;
        });

        // Configuração obrigatória de Organização e Unidade
        $org = Organization::create(['title' => 'Org', 'active' => 1]);
        Unit::create([
            'name'            => 'Secretaria de Mncicipal',
            'sigla'           => 'SECMUN',
            'phone'           => '12345678',
            'web'             => true,
            'city_id'         => 1,
            'organization_id' => $org->id,
        ]);
    }

    public function test_can_view_management_report_index()
    {
        $user = User::factory()->create();
        $type = ManagementReportType::create(['type' => 'Relatório Anual']);
        
        ManagementReport::create([
            'management_report_type_id' => $type->id,
            'initial_date' => '2026-01-01',
            'final_date' => '2026-12-31',
            'status' => 'PUBLISHED',
        ]);

        $response = $this->actingAs($user)->get('/relatorio_de_gestao');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ManagementReport/Index'));
    }

    public function test_can_view_management_report_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/relatorio_de_gestao/create');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ManagementReport/Create'));
    }

    public function test_can_store_management_report()
    {
        $user = User::factory()->create();
        $type = ManagementReportType::create(['type' => 'Relatório Semestral']);

        $response = $this->actingAs($user)
            ->from('/relatorio_de_gestao/create')
            ->post('/relatorio_de_gestao', [
                'management_report_type_id' => $type->id,
                'initial_date' => '2026-01-01',
                'final_date' => '2026-06-30',
                'status' => 'PENDING',
            ]);

        $report = ManagementReport::first();
        $this->assertNotNull($report);

        $response->assertRedirect("/relatorio_de_gestao/{$report->id}");
        $this->assertDatabaseHas('management_reports', [
            'id' => $report->id,
            'management_report_type_id' => $type->id,
            'initial_date' => '2026-01-01',
            'final_date' => '2026-06-30',
            'status' => 'PENDING',
        ]);
    }

    public function test_can_view_management_report_show()
    {
        $user = User::factory()->create();
        $type = ManagementReportType::create(['type' => 'Relatório Trimestral']);
        $report = ManagementReport::create([
            'management_report_type_id' => $type->id,
            'initial_date' => '2026-01-01',
            'final_date' => '2026-03-31',
            'status' => 'DRAFT',
        ]);

        $response = $this->actingAs($user)->get("/relatorio_de_gestao/{$report->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ManagementReport/Show'));
    }

    public function test_can_update_management_report()
    {
        $user = User::factory()->create();
        $type1 = ManagementReportType::create(['type' => 'Tipo A']);
        $type2 = ManagementReportType::create(['type' => 'Tipo B']);
        $report = ManagementReport::create([
            'management_report_type_id' => $type1->id,
            'initial_date' => '2026-01-01',
            'final_date' => '2026-03-31',
            'status' => 'DRAFT',
        ]);

        $response = $this->actingAs($user)
            ->from("/relatorio_de_gestao/{$report->id}")
            ->put("/relatorio_de_gestao/{$report->id}", [
                'management_report_type_id' => $type2->id,
                'initial_date' => '2026-02-01',
                'final_date' => '2026-05-30',
                'status' => 'PUBLISHED',
            ]);

        $response->assertRedirect("/relatorio_de_gestao/{$report->id}");
        $this->assertDatabaseHas('management_reports', [
            'id' => $report->id,
            'management_report_type_id' => $type2->id,
            'initial_date' => '2026-02-01',
            'final_date' => '2026-05-30',
            'status' => 'PUBLISHED',
        ]);
    }

    public function test_can_destroy_management_report()
    {
        $user = User::factory()->create();
        $type = ManagementReportType::create(['type' => 'Tipo C']);
        $report = ManagementReport::create([
            'management_report_type_id' => $type->id,
            'initial_date' => '2026-01-01',
            'final_date' => '2026-03-31',
            'status' => 'DRAFT',
        ]);

        $response = $this->actingAs($user)
            ->from('/relatorio_de_gestao')
            ->delete("/relatorio_de_gestao/{$report->id}");

        $response->assertRedirect('/relatorio_de_gestao');
        $this->assertDatabaseMissing('management_reports', [
            'id' => $report->id,
        ]);
    }

    public function test_public_web_index_remains_blade()
    {
        $type = ManagementReportType::create(['type' => 'Relatório Web']);
        ManagementReport::create([
            'management_report_type_id' => $type->id,
            'initial_date' => '2026-01-01',
            'final_date' => '2026-12-31',
            'status' => 'PUBLISHED',
        ]);

        $response = $this->get('/relatorio_de_gestao_web');

        $response->assertStatus(200);
        
        // Assegurar que não renderiza com Inertia
        $this->assertArrayNotHasKey('page', $response->original);
        $response->assertViewIs('web.management_report.index');
    }
}
