<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Leadership;
use App\Models\SocialMedia;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeadershipTest extends TestCase
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

    public function test_admin_can_view_leaderships_list()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/liderancas');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_show_leadership_page()
    {
        $user = User::factory()->create();
        
        Storage::fake('leadership');
        $photo = UploadedFile::fake()->image('photo.jpg');

        $leadership = Leadership::create([
            'name' => 'Felipe Cruz',
            'occupation' => 'Secretário',
            'order' => 1,
            'photo' => 'photos/photo.jpg',
            'type' => 'HEADSHIP',
            'status' => 'PUBLISHED'
        ]);

        $response = $this->actingAs($user)->get("/liderancas/{$leadership->id}");

        $response->assertStatus(200);
    }

    public function test_admin_can_store_leadership()
    {
        $user = User::factory()->create();

        Storage::fake('leadership');
        $photo = UploadedFile::fake()->image('leadership.jpg');

        $response = $this->actingAs($user)->post('/liderancas', [
            'name' => 'João da Silva',
            'occupation' => 'Diretor',
            'order' => 2,
            'photo' => $photo,
            'type' => 'EMPLOYEE',
            'status' => 'PUBLISHED'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('leaderships', [
            'name' => 'João da Silva',
            'occupation' => 'Diretor',
            'type' => 'EMPLOYEE',
            'status' => 'PUBLISHED'
        ]);
    }

    public function test_admin_can_update_leadership()
    {
        $user = User::factory()->create();

        $leadership = Leadership::create([
            'name' => 'Felipe Cruz',
            'occupation' => 'Secretário',
            'order' => 1,
            'photo' => 'photos/photo.jpg',
            'type' => 'HEADSHIP',
            'status' => 'PUBLISHED'
        ]);

        $response = $this->actingAs($user)->put("/liderancas/{$leadership->id}", [
            'name' => 'Felipe Cruz Editado',
            'occupation' => 'Secretário Adjunto',
            'order' => 1,
            'type' => 'HEADSHIP',
            'status' => 'PUBLISHED'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('leaderships', [
            'id' => $leadership->id,
            'name' => 'Felipe Cruz Editado',
            'occupation' => 'Secretário Adjunto'
        ]);
    }

    public function test_admin_can_associate_social_media_to_leadership()
    {
        $user = User::factory()->create();

        $leadership = Leadership::create([
            'name' => 'Felipe Cruz',
            'occupation' => 'Secretário',
            'order' => 1,
            'photo' => 'photos/photo.jpg',
            'type' => 'HEADSHIP',
            'status' => 'PUBLISHED'
        ]);

        $socialMedia = SocialMedia::create([
            'title' => 'Instagram',
            'logo' => 'logo.png',
            'active' => 1,
        ]);

        $response = $this->actingAs($user)->post('/leadership_social_media_add', [
            'leadership_id' => $leadership->id,
            'social_media_id' => $socialMedia->id,
            'url' => 'https://instagram.com/felipecruz',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('leadership_social_media', [
            'leadership_id' => $leadership->id,
            'social_media_id' => $socialMedia->id,
            'url' => 'https://instagram.com/felipecruz'
        ]);
    }

    public function test_admin_can_disassociate_social_media_from_leadership()
    {
        $user = User::factory()->create();

        $leadership = Leadership::create([
            'name' => 'Felipe Cruz',
            'occupation' => 'Secretário',
            'order' => 1,
            'photo' => 'photos/photo.jpg',
            'type' => 'HEADSHIP',
            'status' => 'PUBLISHED'
        ]);

        $socialMedia = SocialMedia::create([
            'title' => 'Instagram',
            'logo' => 'logo.png',
            'active' => 1,
        ]);

        $leadership->socialMedia()->attach($socialMedia->id, [
            'url' => 'https://instagram.com/felipecruz'
        ]);

        $pivot = $leadership->socialMedia()->first()->pivot;

        $response = $this->actingAs($user)->get("/leadership_social_media_delete/{$pivot->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('leadership_social_media', [
            'id' => $pivot->id
        ]);
    }
}
