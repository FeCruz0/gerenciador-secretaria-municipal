<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ShortcutWeb;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShortcutWebMigrationTest extends TestCase
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

    public function test_can_view_shortcut_web_index()
    {
        $user = User::factory()->create();
        ShortcutWeb::create([
            'title'    => 'Portal da Transparência',
            'img_url'  => 'large/icone.png',
            'link_url' => 'https://transparencia.exemplo.com',
            'order'    => 1,
            'status'   => 'PUBLISHED',
        ]);

        $response = $this->actingAs($user)->get('/web_atalhos');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ShortcutWeb/Index'));
    }

    public function test_can_view_shortcut_web_show()
    {
        $user = User::factory()->create();
        $shortcut = ShortcutWeb::create([
            'title'    => 'Portal da Transparência',
            'img_url'  => 'large/icone.png',
            'link_url' => 'https://transparencia.exemplo.com',
            'order'    => 1,
            'status'   => 'PUBLISHED',
        ]);

        $response = $this->actingAs($user)->get("/web_atalhos/{$shortcut->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ShortcutWeb/Show'));
    }

    public function test_can_store_shortcut_web()
    {
        $user = User::factory()->create();
        Storage::fake('shortcutweb');

        $file = UploadedFile::fake()->image('icone.png');

        $response = $this->actingAs($user)
            ->from('/web_atalhos')
            ->post('/web_atalhos', [
                'title'      => 'Atalho Novo',
                'link_url'   => 'https://novo.com',
                'order'      => 2,
                'status'     => 'PUBLISHED',
                'image_icon' => $file,
            ]);

        $response->assertRedirect('/web_atalhos');
        $this->assertDatabaseHas('shortcut_webs', [
            'title'    => 'Atalho Novo',
            'link_url' => 'https://novo.com',
            'order'    => 2,
            'status'   => 'PUBLISHED',
        ]);

        // Verifica se o arquivo foi enviado para o disco fake
        $shortcut = ShortcutWeb::where('title', 'Atalho Novo')->first();
        Storage::disk('shortcutweb')->assertExists($shortcut->img_url);
    }

    public function test_can_update_shortcut_web_without_new_image()
    {
        $user = User::factory()->create();
        $shortcut = ShortcutWeb::create([
            'title'    => 'Atalho Antigo',
            'img_url'  => 'large/icone.png',
            'link_url' => 'https://antigo.com',
            'order'    => 1,
            'status'   => 'DRAFT',
        ]);

        $response = $this->actingAs($user)
            ->from("/web_atalhos/{$shortcut->id}")
            ->put("/web_atalhos/{$shortcut->id}", [
                'title'    => 'Atalho Editado',
                'link_url' => 'https://editado.com',
                'order'    => 3,
                'status'   => 'PUBLISHED',
            ]);

        $response->assertRedirect("/web_atalhos/{$shortcut->id}");
        $this->assertDatabaseHas('shortcut_webs', [
            'id'       => $shortcut->id,
            'title'    => 'Atalho Editado',
            'link_url' => 'https://editado.com',
            'order'    => 3,
            'status'   => 'PUBLISHED',
            'img_url'  => 'large/icone.png', // A imagem antiga deve se manter
        ]);
    }

    public function test_can_update_shortcut_web_with_new_image()
    {
        $user = User::factory()->create();
        Storage::fake('shortcutweb');

        $shortcut = ShortcutWeb::create([
            'title'    => 'Atalho Antigo',
            'img_url'  => 'large/icone_antigo.png',
            'link_url' => 'https://antigo.com',
            'order'    => 1,
            'status'   => 'DRAFT',
        ]);

        $newFile = UploadedFile::fake()->image('icone_novo.png');

        $response = $this->actingAs($user)
            ->from("/web_atalhos/{$shortcut->id}")
            ->put("/web_atalhos/{$shortcut->id}", [
                'title'      => 'Atalho Editado Com Imagem',
                'link_url'   => 'https://editado.com',
                'order'      => 4,
                'status'     => 'PUBLISHED',
                'image_icon' => $newFile,
            ]);

        $response->assertRedirect("/web_atalhos/{$shortcut->id}");
        $this->assertDatabaseHas('shortcut_webs', [
            'id'       => $shortcut->id,
            'title'    => 'Atalho Editado Com Imagem',
            'order'    => 4,
            'status'   => 'PUBLISHED',
        ]);

        $updatedShortcut = ShortcutWeb::find($shortcut->id);
        $this->assertNotEquals('large/icone_antigo.png', $updatedShortcut->img_url);
        Storage::disk('shortcutweb')->assertExists($updatedShortcut->img_url);
    }

    public function test_can_destroy_shortcut_web()
    {
        $user = User::factory()->create();
        $shortcut = ShortcutWeb::create([
            'title'    => 'Atalho a Deletar',
            'img_url'  => 'large/icone.png',
            'link_url' => 'https://deletar.com',
            'order'    => 1,
            'status'   => 'PUBLISHED',
        ]);

        $response = $this->actingAs($user)->delete("/web_atalhos/{$shortcut->id}");

        $response->assertRedirect('/web_atalhos');
        $this->assertSoftDeleted('shortcut_webs', [
            'id' => $shortcut->id,
        ]);
    }
}
