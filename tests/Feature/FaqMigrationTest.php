<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Faq;
use App\Models\Departament;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class FaqMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createFaqSetup(): Faq
    {
        $org = Organization::create(['title' => 'Org', 'active' => 1]);
        
        $unit = Unit::create([
            'name'            => 'Secretaria de Saúde',
            'sigla'           => 'SESAU',
            'phone'           => '12345678',
            'web'             => true,
            'city_id'         => 1,
            'organization_id' => $org->id,
        ]);

        $departament = Departament::create([
            'departament' => 'Assessoria Jurídica',
            'code'        => 'AJUR',
            'sigla'       => 'AJUR',
            'unit_id'     => $unit->id,
        ]);

        return Faq::create([
            'departament_id' => $departament->id,
            'question'       => 'Como solicito atendimento?',
            'answer'         => 'Pelo portal da secretaria ou pelo telefone.',
            'status'         => 'PUBLISHED',
        ]);
    }

    public function test_admin_can_view_faq_index()
    {
        $user = User::factory()->create();
        $this->createFaqSetup();

        $response = $this->actingAs($user)->get('/faqs');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Faq/Index'));
    }

    public function test_admin_can_store_faq()
    {
        $user = User::factory()->create();
        $faq = $this->createFaqSetup();

        $response = $this->actingAs($user)->post('/faqs', [
            'question'       => 'Nova Pergunta?',
            'answer'         => 'Nova Resposta.',
            'departament_id' => $faq->departament_id,
            'status'         => 'DRAFT',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('faqs', [
            'question' => 'Nova Pergunta?',
            'status'   => 'DRAFT',
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();
        $this->createFaqSetup();

        $response = $this->actingAs($user)->post('/faqs', [
            'question' => '',
            'answer'   => '',
        ]);

        $response->assertSessionHasErrors(['question', 'answer', 'departament_id', 'status']);
    }

    public function test_admin_can_view_faq_show()
    {
        $user = User::factory()->create();
        $faq = $this->createFaqSetup();

        $response = $this->actingAs($user)->get("/faqs/{$faq->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Faq/Show'));
    }

    public function test_admin_can_update_faq()
    {
        $user = User::factory()->create();
        $faq = $this->createFaqSetup();

        $response = $this->actingAs($user)->put("/faqs/{$faq->id}", [
            'question'       => 'Pergunta Atualizada?',
            'answer'         => 'Resposta Atualizada.',
            'departament_id' => $faq->departament_id,
            'status'         => 'PENDING',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('faqs', [
            'id'       => $faq->id,
            'question' => 'Pergunta Atualizada?',
            'status'   => 'PENDING',
        ]);
    }

    public function test_admin_can_delete_faq()
    {
        $user = User::factory()->create();
        $faq = $this->createFaqSetup();

        $response = $this->actingAs($user)->delete("/faqs/{$faq->id}");

        $response->assertRedirect('/faqs');
        $this->assertSoftDeleted('faqs', [
            'id' => $faq->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_faqs()
    {
        $response = $this->get('/faqs');

        $response->assertRedirect('/login');
    }
}
