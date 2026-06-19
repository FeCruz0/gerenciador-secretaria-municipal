<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Media;
use App\Models\TypePost;
use App\Models\TypeMedia;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createPostSetup(): Post
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

        $typePost = TypePost::create([
            'id'    => 1,
            'title' => 'banner',
        ]);

        $typeMediaWeb = TypeMedia::create([
            'id'    => 1,
            'title' => 'banner_lg',
        ]);

        $typeMediaPhone = TypeMedia::create([
            'id'    => 2,
            'title' => 'banner_sm',
        ]);

        $user = User::factory()->create();

        $post = Post::create([
            'type_post_id' => $typePost->id,
            'user_id'      => $user->id,
            'title'        => 'Capa do Evento',
            'sub_title'    => 'Subtitulo do Evento',
            'order'        => 1,
            'link'         => 'https://example.com',
            'content'      => 'Conteudo do post',
            'active'       => 1,
        ]);

        Media::create([
            'post_id'       => $post->id,
            'type_media_id' => 1,
            'url'           => 'web/test-web.jpg',
        ]);

        return $post;
    }

    public function test_admin_can_view_post_index()
    {
        $user = User::factory()->create();
        $this->createPostSetup();

        $response = $this->actingAs($user)->get('/capas');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Post/Index'));
    }

    public function test_admin_can_store_post()
    {
        $user = User::factory()->create();
        $this->createPostSetup();

        Storage::fake('posts');

        $response = $this->actingAs($user)->post('/capas', [
            'title'      => 'Nova Capa',
            'sub_title'  => 'Nova Sub',
            'order'      => 2,
            'link'       => 'https://google.com',
            'content'    => 'Texto da capa',
            'active'     => 1,
            'image_web'  => UploadedFile::fake()->image('web_banner.jpg'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Nova Capa',
            'order' => 2,
        ]);
        
        $post = Post::where('title', 'Nova Capa')->first();
        $this->assertNotNull($post);
        $this->assertDatabaseHas('media', [
            'post_id'       => $post->id,
            'type_media_id' => 1,
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();
        $this->createPostSetup();

        $response = $this->actingAs($user)->post('/capas', [
            'title' => 'Capa Sem Imagem',
            // image_web is missing
        ]);

        $response->assertSessionHasErrors(['image_web']);
    }

    public function test_admin_can_view_post_show()
    {
        $user = User::factory()->create();
        $post = $this->createPostSetup();

        $response = $this->actingAs($user)->get("/capas/{$post->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Post/Show'));
    }

    public function test_admin_can_update_post()
    {
        $user = User::factory()->create();
        $post = $this->createPostSetup();

        Storage::fake('posts');

        $response = $this->actingAs($user)->put("/capas/{$post->id}", [
            'title'        => 'Capa Atualizada',
            'sub_title'    => 'Sub Atualizada',
            'order'        => 3,
            'link'         => 'https://updated.com',
            'content'      => 'Conteudo Atualizado',
            'active'       => 0,
            'image'        => UploadedFile::fake()->image('updated_web.jpg'),
            'image_mobile' => UploadedFile::fake()->image('updated_mobile.jpg'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Capa Atualizada',
            'order' => 3,
            'active'=> 0,
        ]);

        $this->assertDatabaseHas('media', [
            'post_id'       => $post->id,
            'type_media_id' => 1,
        ]);
    }

    public function test_admin_can_delete_post()
    {
        $user = User::factory()->create();
        $post = $this->createPostSetup();

        $response = $this->actingAs($user)->delete("/capas/{$post->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_posts()
    {
        $response = $this->get('/capas');

        $response->assertRedirect('/login');
    }
}
