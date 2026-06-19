<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Gallery;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createGallerySetup(): Gallery
    {
        $org = Organization::create(['title' => 'Org', 'active' => 1]);
        Unit::create([
            'name'            => 'Secretaria de Saúde',
            'sigla'           => 'SESAU',
            'phone'           => '12345678',
            'web'             => true,
            'city_id'         => 1,
            'organization_id' => $org->id,
        ]);

        return Gallery::create([
            'title'       => 'Foto do Evento',
            'order'       => 1,
            'image_small' => 'small/test-small.jpg',
            'image_large' => 'large/test-large.jpg',
            'status'      => 'PUBLISHED',
        ]);
    }

    public function test_admin_can_view_gallery_index()
    {
        $user = User::factory()->create();
        $gallery = $this->createGallerySetup();

        $response = $this->actingAs($user)->get('/galeria_imagens');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Gallery/Index'));
    }

    public function test_admin_can_store_gallery_item()
    {
        $user = User::factory()->create();
        $this->createGallerySetup();

        Storage::fake('gallery');

        $response = $this->actingAs($user)->post('/galeria_imagens', [
            'title'       => 'Nova Imagem',
            'order'       => 2,
            'status'      => 'DRAFT',
            'image_small' => UploadedFile::fake()->image('small.jpg'),
            'image_large' => UploadedFile::fake()->image('large.jpg'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('galleries', [
            'title'  => 'Nova Imagem',
            'order'  => 2,
            'status' => 'DRAFT',
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();
        $this->createGallerySetup();

        $response = $this->actingAs($user)->post('/galeria_imagens', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_admin_can_view_gallery_show()
    {
        $user = User::factory()->create();
        $gallery = $this->createGallerySetup();

        $response = $this->actingAs($user)->get("/galeria_imagens/{$gallery->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Gallery/Show'));
    }

    public function test_admin_can_update_gallery_item()
    {
        $user = User::factory()->create();
        $gallery = $this->createGallerySetup();

        Storage::fake('gallery');

        // Update com novas imagens (via POST + _method spoofing)
        $response = $this->actingAs($user)->put("/galeria_imagens/{$gallery->id}", [
            'title'       => 'Imagem Atualizada',
            'order'       => 5,
            'status'      => 'PUBLISHED',
            'image_small' => UploadedFile::fake()->image('new-small.jpg'),
            'image_large' => UploadedFile::fake()->image('new-large.jpg'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('galleries', [
            'id'    => $gallery->id,
            'title' => 'Imagem Atualizada',
            'order' => 5,
        ]);
    }

    public function test_admin_can_delete_gallery_item()
    {
        $user = User::factory()->create();
        $gallery = $this->createGallerySetup();

        $response = $this->actingAs($user)->delete("/galeria_imagens/{$gallery->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('galleries', [
            'id' => $gallery->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_gallery()
    {
        $response = $this->get('/galeria_imagens');

        $response->assertRedirect('/login');
    }
}
