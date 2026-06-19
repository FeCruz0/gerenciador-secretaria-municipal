<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Banner;
use App\Models\BannerType;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BannerMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createBannerSetup(): BannerType
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

        $type = BannerType::create([
            'title'  => 'Banner da Home',
            'status' => 'PUBLISHED',
        ]);

        Banner::create([
            'banner_type_id' => $type->id,
            'title'          => 'Texto de Boas Vindas',
            'image'          => 'banners/welcome.jpg',
            'status'         => 'PUBLISHED',
        ]);

        return $type;
    }

    public function test_admin_can_view_banner_index()
    {
        $user = User::factory()->create();
        $this->createBannerSetup();

        $response = $this->actingAs($user)->get('/banners');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Banner/Index'));
    }

    public function test_admin_can_update_or_create_banner()
    {
        $user = User::factory()->create();
        $type = $this->createBannerSetup();

        Storage::fake('banners');

        $response = $this->actingAs($user)->put("/banners/{$type->id}", [
            'title'  => 'Novo Titulo do Banner',
            'status' => 'DRAFT',
            'image'  => UploadedFile::fake()->image('homepage_banner.png'),
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('banners', [
            'banner_type_id' => $type->id,
            'title'          => 'Novo Titulo do Banner',
            'status'         => 'DRAFT',
        ]);
    }

    public function test_update_validates_required_fields()
    {
        $user = User::factory()->create();
        $type = $this->createBannerSetup();

        $response = $this->actingAs($user)->put("/banners/{$type->id}", [
            'title'  => '',
            // image is missing
        ]);

        $response->assertSessionHasErrors(['title', 'image']);
    }

    public function test_unauthenticated_user_cannot_access_banners()
    {
        $response = $this->get('/banners');

        $response->assertRedirect('/login');
    }
}
