<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Unit;
use App\Models\Organization;
use App\Models\SocialMedia;
use App\Models\About;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UnitMigrationTest extends TestCase
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
            'email' => 'teste@teste.com',
            'operation' => 'Segunda a Sexta das 8h as 17h',
            'address' => 'Rua do Teste, 123',
            'google_maps_link' => 'https://goo.gl/maps/teste',
            'google_maps_iframe' => 'https://www.google.com/maps/embed?pb=teste',
            'web' => true,
            'organization_id' => $org->id,
        ]);
    }

    public function test_admin_can_view_units_list()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/unidades');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_show_unit_page()
    {
        $user = User::factory()->create();
        $unit = Unit::first();

        $response = $this->actingAs($user)->get("/unidades/{$unit->id}");

        $response->assertStatus(200);
    }

    public function test_admin_can_store_unit()
    {
        $user = User::factory()->create();
        $org = Organization::first();

        $response = $this->actingAs($user)->post('/unidades', [
            'name' => 'Nova Secretaria de Obras',
            'sigla' => 'SOB',
            'organization_id' => $org->id,
            'phone' => '123456789',
            'email' => 'obras@teste.com',
            'operation' => '8h às 17h',
            'address' => 'Rua Obras, 456',
            'google_maps_link' => 'https://maps.google.com/teste',
            'google_maps_iframe' => 'https://maps.google.com/embed/teste',
            'web' => 0,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('units', [
            'name' => 'Nova Secretaria de Obras',
            'sigla' => 'SOB',
        ]);
    }

    public function test_admin_can_update_unit()
    {
        $user = User::factory()->create();
        $unit = Unit::first();
        $org = Organization::first();

        $response = $this->actingAs($user)->put("/unidades/{$unit->id}", [
            'name' => 'Secretaria Teste Editada',
            'sigla' => 'SECED',
            'organization_id' => $org->id,
            'phone' => '987654321',
            'email' => 'teste_ed@teste.com',
            'operation' => '8h às 18h',
            'address' => 'Rua do Teste Editada, 123',
            'google_maps_link' => 'https://goo.gl/maps/teste_ed',
            'google_maps_iframe' => 'https://www.google.com/maps/embed?pb=teste_ed',
            'web' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('units', [
            'id' => $unit->id,
            'name' => 'Secretaria Teste Editada',
            'sigla' => 'SECED',
        ]);
    }

    public function test_admin_can_associate_social_media_to_unit()
    {
        $user = User::factory()->create();
        $unit = Unit::first();

        $socialMedia = SocialMedia::create([
            'title' => 'Instagram',
            'logo' => 'logo.png',
            'active' => 1,
        ]);

        $response = $this->actingAs($user)->post('/unidade_social_media_add', [
            'unit_id' => $unit->id,
            'social_media_id' => $socialMedia->id,
            'url' => 'https://instagram.com/secretariateste',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('social_media_unit', [
            'unit_id' => $unit->id,
            'social_media_id' => $socialMedia->id,
            'url' => 'https://instagram.com/secretariateste'
        ]);
    }

    public function test_admin_can_disassociate_social_media_from_unit()
    {
        $user = User::factory()->create();
        $unit = Unit::first();

        $socialMedia = SocialMedia::create([
            'title' => 'Instagram',
            'logo' => 'logo.png',
            'active' => 1,
        ]);

        $unit->socialMedia()->attach($socialMedia->id, [
            'url' => 'https://instagram.com/secretariateste'
        ]);

        $pivot = $unit->socialMedia()->first()->pivot;

        $response = $this->actingAs($user)->get("/unidade_social_media_delete/{$pivot->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('social_media_unit', [
            'id' => $pivot->id
        ]);
    }

    public function test_admin_can_update_about_section()
    {
        $user = User::factory()->create();
        $unit = Unit::first();

        $about = About::create([
            'unit_id' => $unit->id,
            'title' => 'Sobre a Secretaria',
            'sub_title' => 'Subtítulo',
            'founded_at' => '2026-01-01',
            'description' => 'Descrição inicial',
            'body' => 'Corpo do texto',
            'image' => 'about.png',
            'status' => 'PUBLISHED'
        ]);

        $response = $this->actingAs($user)->put("/sobres/{$about->id}", [
            'unit_id' => $unit->id,
            'title' => 'Sobre a Secretaria Editado',
            'sub_title' => 'Subtítulo Editado',
            'founded_at' => '2026-01-01',
            'description' => 'Descrição editada',
            'content' => 'Corpo editado',
            'status' => 'PUBLISHED'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('abouts', [
            'id' => $about->id,
            'title' => 'Sobre a Secretaria Editado',
            'description' => 'Descrição editada'
        ]);
    }
}
