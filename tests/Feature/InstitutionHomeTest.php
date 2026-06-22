<?php

namespace Tests\Feature;

use App\Models\Organ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitutionHomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Cadastra alguns órgãos ativos no banco de teste
        Organ::create([
            'name' => 'Secretaria de Meio Ambiente',
            'sigla' => 'GESEM',
            'slug' => 'gesem',
            'is_active' => true,
        ]);

        Organ::create([
            'name' => 'Secretaria de Educação',
            'sigla' => 'EDUC',
            'slug' => 'educ',
            'is_active' => true,
        ]);

        // Cadastra um órgão inativo
        Organ::create([
            'name' => 'Secretaria Inativa',
            'sigla' => 'INAT',
            'slug' => 'inat',
            'is_active' => false,
        ]);
    }

    /**
     * Test that root home page returns 200 status code and lists active organs.
     */
    public function test_root_home_page_is_accessible_directly_without_redirect()
    {
        $response = $this->get('/');

        // Deve retornar 200 OK (anteriormente redirecionava para o primeiro órgão ativo)
        $response->assertStatus(200);

        // Deve renderizar a view do blade público do portal principal
        $response->assertViewIs('web.home.home');

        // Deve conter a lista de órgãos ativos na view
        $response->assertViewHas('organs');

        // Deve exibir os nomes/siglas dos órgãos ativos na home pública
        $response->assertSee('GESEM');
        $response->assertSee('EDUC');
        
        // Não deve exibir o órgão inativo
        $response->assertDontSee('INAT');
    }
}
