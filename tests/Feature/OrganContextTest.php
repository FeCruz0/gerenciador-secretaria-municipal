<?php

namespace Tests\Feature;

use App\Models\Organ;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganContextTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard active organ
        Organ::create([
            'name' => 'Secretaria de Meio Ambiente e Saneamento',
            'sigla' => 'GESEM',
            'slug' => 'gesem',
            'theme_color_hex' => '#10b981',
            'logo_path' => 'gesem-logo.svg',
            'is_active' => true,
        ]);

        // Create another active organ
        Organ::create([
            'name' => 'Secretaria de Educação',
            'sigla' => 'EDUC',
            'slug' => 'educ',
            'theme_color_hex' => '#3b82f6',
            'logo_path' => 'educ-logo.svg',
            'is_active' => true,
        ]);

        // Create an inactive organ
        Organ::create([
            'name' => 'Secretaria Inativa',
            'sigla' => 'INAT',
            'slug' => 'inat',
            'theme_color_hex' => '#ef4444',
            'logo_path' => 'inat-logo.svg',
            'is_active' => false,
        ]);
    }

    /**
     * Test root URL loads the generic institution home page instead of redirecting.
     */
    public function test_root_loads_generic_institution_home()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test active organ homepage is accessible.
     */
    public function test_active_organ_homepage_is_accessible()
    {
        // First active organ
        $response = $this->get('/gesem');
        $response->assertStatus(200);

        // Second active organ
        $response = $this->get('/educ');
        $response->assertStatus(200);
    }

    /**
     * Test inactive or non-existent organs return 404.
     */
    public function test_inactive_or_non_existent_organs_return_404()
    {
        // Inactive organ
        $response = $this->get('/inat');
        $response->assertStatus(404);

        // Non-existent organ
        $response = $this->get('/non-existent');
        $response->assertStatus(404);
    }

    /**
     * Test data isolation (OrganScope) between organs.
     */
    public function test_data_isolation_between_organs()
    {
        $gesem = Organ::where('slug', 'gesem')->first();
        $educ = Organ::where('slug', 'educ')->first();

        // Create a user
        $user = \App\Models\User::factory()->create();

        // Create news for GESEM
        News::create([
            'title' => 'Notícia da GESEM',
            'body' => 'Conteúdo da GESEM',
            'excerpt' => 'Resumo da notícia da GESEM',
            'status' => 'PUBLISHED',
            'organ_id' => $gesem->id,
            'user_id' => $user->id,
            'meta_description' => 'Meta description GESEM',
            'meta_keywords' => 'meta, keywords, gesem',
            'seo_title' => 'SEO Title GESEM',
        ]);

        // Create news for EDUC
        News::create([
            'title' => 'Notícia da EDUC',
            'body' => 'Conteúdo da EDUC',
            'excerpt' => 'Resumo da notícia da EDUC',
            'status' => 'PUBLISHED',
            'organ_id' => $educ->id,
            'user_id' => $user->id,
            'meta_description' => 'Meta description EDUC',
            'meta_keywords' => 'meta, keywords, educ',
            'seo_title' => 'SEO Title EDUC',
        ]);

        // Scope active organ as GESEM and verify
        app()->instance('active_organ', $gesem);
        $gesemNews = News::all();
        $this->assertCount(1, $gesemNews);
        $this->assertEquals('Notícia da GESEM', $gesemNews->first()->title);

        // Scope active organ as EDUC and verify
        app()->instance('active_organ', $educ);
        $educNews = News::all();
        $this->assertCount(1, $educNews);
        $this->assertEquals('Notícia da EDUC', $educNews->first()->title);
    }
}
