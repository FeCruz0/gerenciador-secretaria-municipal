<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Legislation;
use App\Models\LegislationCategory;
use App\Models\LegislationSituation;
use App\Models\LegislationSubject;
use App\Models\LegislationBond;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class LegislationAuxMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });

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

    // ==========================================
    // LEGISLATION CATEGORY TESTS
    // ==========================================

    public function test_can_view_category_index()
    {
        $user = User::factory()->create();
        LegislationCategory::create(['category' => 'Categoria 1', 'active' => 1]);

        $response = $this->actingAs($user)->get('/legislacao_categorias');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('LegislationCategory/Index'));
    }

    public function test_can_view_category_show()
    {
        $user = User::factory()->create();
        $category = LegislationCategory::create(['category' => 'Categoria 1', 'active' => 1]);

        $response = $this->actingAs($user)->get("/legislacao_categorias/{$category->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('LegislationCategory/Show'));
    }

    public function test_can_store_category()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/legislacao_categorias')
            ->post('/legislacao_categorias', [
                'category' => 'Nova Categoria',
            ]);

        $response->assertRedirect('/legislacao_categorias');
        $this->assertDatabaseHas('legislation_categories', [
            'category' => 'Nova Categoria',
        ]);
    }

    public function test_can_update_category()
    {
        $user = User::factory()->create();
        $category = LegislationCategory::create(['category' => 'Categoria Antiga', 'active' => 1]);

        $response = $this->actingAs($user)
            ->from("/legislacao_categorias/{$category->id}")
            ->put("/legislacao_categorias/{$category->id}", [
                'category' => 'Categoria Atualizada',
            ]);

        $response->assertRedirect("/legislacao_categorias/{$category->id}");
        $this->assertDatabaseHas('legislation_categories', [
            'id' => $category->id,
            'category' => 'Categoria Atualizada',
        ]);
    }

    public function test_can_destroy_category()
    {
        $user = User::factory()->create();
        $category = LegislationCategory::create(['category' => 'Categoria a Remover', 'active' => 1]);

        $response = $this->actingAs($user)->delete("/legislacao_categorias/{$category->id}");

        $response->assertRedirect('/legislacao_categorias');
        $this->assertSoftDeleted('legislation_categories', [
            'id' => $category->id,
        ]);
    }

    // ==========================================
    // LEGISLATION SITUATION TESTS
    // ==========================================

    public function test_can_view_situation_index()
    {
        $user = User::factory()->create();
        LegislationSituation::create(['situation' => 'Situação 1', 'active' => 1]);

        $response = $this->actingAs($user)->get('/legislacao_situacoes');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('LegislationSituation/Index'));
    }

    public function test_can_view_situation_show()
    {
        $user = User::factory()->create();
        $situation = LegislationSituation::create(['situation' => 'Situação 1', 'active' => 1]);

        $response = $this->actingAs($user)->get("/legislacao_situacoes/{$situation->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('LegislationSituation/Show'));
    }

    public function test_can_store_situation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/legislacao_situacoes')
            ->post('/legislacao_situacoes', [
                'situation' => 'Nova Situação',
            ]);

        $response->assertRedirect('/legislacao_situacoes');
        $this->assertDatabaseHas('legislation_situations', [
            'situation' => 'Nova Situação',
        ]);
    }

    public function test_can_update_situation()
    {
        $user = User::factory()->create();
        $situation = LegislationSituation::create(['situation' => 'Situação Antiga', 'active' => 1]);

        $response = $this->actingAs($user)
            ->from("/legislacao_situacoes/{$situation->id}")
            ->put("/legislacao_situacoes/{$situation->id}", [
                'situation' => 'Situação Atualizada',
            ]);

        $response->assertRedirect("/legislacao_situacoes/{$situation->id}");
        $this->assertDatabaseHas('legislation_situations', [
            'id' => $situation->id,
            'situation' => 'Situação Atualizada',
        ]);
    }

    public function test_can_destroy_situation()
    {
        $user = User::factory()->create();
        $situation = LegislationSituation::create(['situation' => 'Situação a Remover', 'active' => 1]);

        $response = $this->actingAs($user)->delete("/legislacao_situacoes/{$situation->id}");

        $response->assertRedirect('/legislacao_situacoes');
        $this->assertSoftDeleted('legislation_situations', [
            'id' => $situation->id,
        ]);
    }

    // ==========================================
    // LEGISLATION SUBJECT TESTS
    // ==========================================

    public function test_can_view_subject_index()
    {
        $user = User::factory()->create();
        LegislationSubject::create(['subject' => 'Assunto 1', 'active' => 1]);

        $response = $this->actingAs($user)->get('/legislacao_assuntos');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('LegislationSubject/Index'));
    }

    public function test_can_view_subject_show()
    {
        $user = User::factory()->create();
        $subject = LegislationSubject::create(['subject' => 'Assunto 1', 'active' => 1]);

        $response = $this->actingAs($user)->get("/legislacao_assuntos/{$subject->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('LegislationSubject/Show'));
    }

    public function test_can_store_subject()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/legislacao_assuntos')
            ->post('/legislacao_assuntos', [
                'subject' => 'Novo Assunto',
            ]);

        $response->assertRedirect('/legislacao_assuntos');
        $this->assertDatabaseHas('legislation_subjects', [
            'subject' => 'Novo Assunto',
        ]);
    }

    public function test_can_update_subject()
    {
        $user = User::factory()->create();
        $subject = LegislationSubject::create(['subject' => 'Assunto Antigo', 'active' => 1]);

        $response = $this->actingAs($user)
            ->from("/legislacao_assuntos/{$subject->id}")
            ->put("/legislacao_assuntos/{$subject->id}", [
                'subject' => 'Assunto Atualizado',
            ]);

        $response->assertRedirect("/legislacao_assuntos/{$subject->id}");
        $this->assertDatabaseHas('legislation_subjects', [
            'id' => $subject->id,
            'subject' => 'Assunto Atualizado',
        ]);
    }

    public function test_can_destroy_subject()
    {
        $user = User::factory()->create();
        $subject = LegislationSubject::create(['subject' => 'Assunto a Remover', 'active' => 1]);

        $response = $this->actingAs($user)->delete("/legislacao_assuntos/{$subject->id}");

        $response->assertRedirect('/legislacao_assuntos');
        $this->assertSoftDeleted('legislation_subjects', [
            'id' => $subject->id,
        ]);
    }

    // ==========================================
    // LEGISLATION BOND TESTS
    // ==========================================

    public function test_can_view_bond_show()
    {
        $user = User::factory()->create();
        $legBase = $this->createLegislation();
        $legVinculo = $this->createLegislation();

        $bond = LegislationBond::create([
            'base_id'    => $legBase->id,
            'vinculo_id' => $legVinculo->id,
            'status'     => 'VINCULADO',
            'active'     => 1,
        ]);

        $response = $this->actingAs($user)->get("/legislacao_vinculos/{$bond->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('LegislationBond/Show'));
    }

    public function test_can_store_bond()
    {
        $user = User::factory()->create();
        $legBase = $this->createLegislation();
        $legVinculo = $this->createLegislation();

        $response = $this->actingAs($user)
            ->from('/legislacao_vinculos')
            ->post('/legislacao_vinculos', [
                'base_id'    => $legBase->id,
                'vinculo_id' => $legVinculo->id,
                'status'     => 'VINCULADO',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('legislation_bonds', [
            'base_id'    => $legBase->id,
            'vinculo_id' => $legVinculo->id,
        ]);
    }

    public function test_can_update_bond()
    {
        $user = User::factory()->create();
        $legBase = $this->createLegislation();
        $legVinculo = $this->createLegislation();
        $legVinculoNovo = $this->createLegislation();

        $bond = LegislationBond::create([
            'base_id'    => $legBase->id,
            'vinculo_id' => $legVinculo->id,
            'status'     => 'VINCULADO',
            'active'     => 1,
        ]);

        $response = $this->actingAs($user)
            ->from("/legislacao_vinculos/{$bond->id}")
            ->put("/legislacao_vinculos/{$bond->id}", [
                'base_id'    => $legBase->id,
                'vinculo_id' => $legVinculoNovo->id,
                'status'     => 'ALTERADO',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('legislation_bonds', [
            'id'         => $bond->id,
            'vinculo_id' => $legVinculoNovo->id,
            'status'     => 'ALTERADO',
        ]);
    }

    public function test_can_destroy_bond()
    {
        $user = User::factory()->create();
        $legBase = $this->createLegislation();
        $legVinculo = $this->createLegislation();

        $bond = LegislationBond::create([
            'base_id'    => $legBase->id,
            'vinculo_id' => $legVinculo->id,
            'status'     => 'VINCULADO',
            'active'     => 1,
        ]);

        $response = $this->actingAs($user)->delete("/legislacao_vinculos/{$bond->id}");

        $response->assertRedirect('/legislacoes');
        $this->assertSoftDeleted('legislation_bonds', [
            'id' => $bond->id,
        ]);
    }
}
