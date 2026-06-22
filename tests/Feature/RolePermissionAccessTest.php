<?php

namespace Tests\Feature;

use App\Models\Organ;
use App\Models\User;
use App\Enums\Permission as PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Tests\TestCase;

class RolePermissionAccessTest extends TestCase
{
    use RefreshDatabase;

    protected SpatiePermission $manageEntitiesPermission;

    protected function setUp(): void
    {
        parent::setUp();

        // Garante a existência da permissão no banco de dados do teste
        $this->manageEntitiesPermission = SpatiePermission::firstOrCreate([
            'name' => PermissionEnum::MANAGE_ENTITIES->value,
            'guard_name' => 'web'
        ]);
    }

    /**
     * Test that user without "Gerenciar Entidades" permission cannot access organ listing.
     */
    public function test_user_without_permission_cannot_access_organ_listing()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/orgaos');

        $response->assertStatus(403);
    }

    /**
     * Test that user with "Gerenciar Entidades" permission can access organ listing.
     */
    public function test_user_with_permission_can_access_organ_listing()
    {
        $user = User::factory()->create();
        $user->givePermissionTo($this->manageEntitiesPermission);

        $response = $this->actingAs($user)->get('/orgaos');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Organ/Index'));
    }

    /**
     * Test that authorized user can create an organ and a subsecretariat.
     */
    public function test_authorized_user_can_create_organ_and_subsecretariat()
    {
        $user = User::factory()->create();
        $user->givePermissionTo($this->manageEntitiesPermission);

        // 1. Cadastra Órgão Principal
        $response = $this->actingAs($user)->post('/orgaos', [
            'name' => 'Secretaria de Meio Ambiente',
            'sigla' => 'SEMA',
            'theme_color_hex' => '#10b981',
            'is_active' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('organs', [
            'name' => 'Secretaria de Meio Ambiente',
            'sigla' => 'SEMA',
            'slug' => 'secretaria-de-meio-ambiente',
            'parent_id' => null,
        ]);

        $parentOrgan = Organ::where('slug', 'secretaria-de-meio-ambiente')->first();

        // 2. Cadastra Subsecretaria vinculada ao órgão principal
        $responseSub = $this->actingAs($user)->post('/orgaos', [
            'name' => 'Subsecretaria de Saneamento',
            'sigla' => 'SUB-SAN',
            'theme_color_hex' => '#0d9488',
            'parent_id' => $parentOrgan->id,
            'is_active' => true,
        ]);

        $responseSub->assertRedirect();
        $this->assertDatabaseHas('organs', [
            'name' => 'Subsecretaria de Saneamento',
            'sigla' => 'SUB-SAN',
            'slug' => 'subsecretaria-de-saneamento',
            'parent_id' => $parentOrgan->id,
        ]);
    }

    /**
     * Test hierarchy constraints: subsecretariats cannot have subsecretariats.
     */
    public function test_cannot_bind_subsecretariat_to_another_subsecretariat()
    {
        $user = User::factory()->create();
        $user->givePermissionTo($this->manageEntitiesPermission);

        // Órgão Principal
        $parent = Organ::create([
            'name' => 'Secretaria de Meio Ambiente',
            'sigla' => 'SEMA',
            'slug' => 'sema',
            'is_active' => true,
        ]);

        // Subsecretaria (Filha de SEMA)
        $child = Organ::create([
            'name' => 'Subsecretaria de Saneamento',
            'sigla' => 'SUB-SAN',
            'slug' => 'sub-san',
            'parent_id' => $parent->id,
            'is_active' => true,
        ]);

        // Tentar cadastrar um neto (vinculado a SUB-SAN)
        $response = $this->actingAs($user)->post('/orgaos', [
            'name' => 'Departamento de Poda',
            'sigla' => 'PODA',
            'theme_color_hex' => '#000000',
            'parent_id' => $child->id,
            'is_active' => true,
        ]);

        // Deve falhar com erro de validação/regra de negócio no flash
        $response->assertRedirect();
        $this->assertDatabaseMissing('organs', [
            'name' => 'Departamento de Poda',
            'parent_id' => $child->id,
        ]);
    }
}
