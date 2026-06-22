# Arquitetura Multi-Órgão e Hierárquica

Este documento detalha o funcionamento técnico da infraestrutura multi-órgão (multi-tenant) e a hierarquia administrativa (Órgãos principais e Subsecretarias) implementadas no sistema.

---

## 🏛️ 1. Conceito e Escopo

A aplicação opera sob uma arquitetura de banco de dados único e isolamento de dados via software. Cada entidade municipal (como secretarias, autarquias ou o gabinete do prefeito) representa um **Órgão (Organ)** e possui:
1. **Portal Público Próprio**: Acessado via subpasta baseada no slug do órgão (ex: `site.com.br/gesem` ou `site.com.br/educ`).
2. **Dashboard de Administração**: Gerenciado em `/{slug}/admin/dashboard` com visual e permissões isoladas.
3. **Módulos Modulares**: Banners, notícias, atalhos, faqs e módulos de transparência próprios.

A **Prefeitura Municipal** (Instituição) opera no topo da hierarquia, respondendo diretamente na raiz do domínio (`/`).

---

## 🔗 2. Fluxo Hierárquico: Órgãos e Subsecretarias

Para refletir a organização da administração pública real, a tabela `organs` possui um campo de auto-relacionamento recursivo:
*   `parent_id` (chave estrangeira referenciando `organs.id`, anulável).

### Regras de Negócio e Validações:
1. **Nível Máximo de Recursão**: A hierarquia é limitada a 2 níveis: **Órgão Principal** (ex: Secretaria de Meio Ambiente) -> **Subsecretaria** (ex: Subsecretaria de Saneamento).
2. **Impedimento de Recursão Profunda**: Não é permitido criar um "neto" (vincular uma subsecretaria a outra subsecretaria).
3. **Impedimento de Auto-Vínculo**: Um órgão não pode ser pai de si mesmo.
4. **Bypass de Órgãos com Filhos**: Se um órgão principal já possui subsecretarias vinculadas a ele, ele não pode ser convertido em subsecretaria (vínculo de parent_id impedido).

---

## ⚙️ 3. Como Funciona o Isolamento de Dados

O isolamento é automatizado e invisível aos controllers através de duas peças fundamentais:

### 1. Middleware de Contexto (`OrganContextMiddleware`)
Registrado globalmente no grupo `web`, ele:
*   Analisa o prefixo `{organ}` na rota do Laravel.
*   Instancia o model `Organ` correspondente no container de serviços da aplicação (`active_organ`).
*   Configura os parâmetros padrão do gerador de URLs do Laravel (`URL::defaults(['organ' => $slug])`), garantindo que todos os links gerados pelo helper `route()` herdem automaticamente a slug do órgão ativo sem precisar passá-la manualmente no frontend ou backend.
*   Esquece o parâmetro dinâmico do request (`forgetParameter('organ')`) para que os controllers não precisem declará-lo como argumento em suas funções.

### 2. Escopo Global de Consulta (`OrganScope`)
Adicionado aos models críticos (`News`, `Bidding`, `Banner`, `FAQ`, `ShortcutWeb`, `User`, `HomeModule`, `Departament`):
*   Sempre que uma query é executada no banco, o escopo injeta automaticamente a restrição `where('organ_id', $activeOrganId)`.
*   Para consultas administrativas que exijam acesso global da prefeitura ou bypassing do isolamento, pode-se usar o método `withoutGlobalScope`:
    ```php
    $allBanners = Banner::withoutGlobalScope(OrganScope::class)->get();
    ```

---

## 💾 4. Atualizando as Migrations e Banco de Dados

Se você acabou de trazer as alterações do repositório para a sua máquina ou branch, siga os comandos abaixo para sincronizar a sua base de dados local.

### Cenário A: Aplicar as novas migrations (Sem perder dados existentes)
Use este comando para rodar apenas as novas migrations de tabelas e colunas criadas no banco de dados local:

*   **Via Docker Compose puro:**
    ```bash
    docker-compose exec -u sail laravel.test php artisan migrate
    ```

*   **Via Docker puro (Container direto):**
    ```bash
    docker exec -it gerenciador-secretaria-municipal-laravel.test-1 php artisan migrate
    ```

### Cenário B: Recriar o banco do zero (Recomendado para Desenvolvimento)
Para limpar o banco de dados completamente, recriar todas as tabelas na estrutura correta de múltiplos órgãos e inserir os dados de teste e seeders padrão (incluindo usuários admin, novos órgãos `gesem`, `educ` e as permissões de acesso):

*   **Via Docker Compose puro:**
    ```bash
    docker-compose exec -u sail laravel.test php artisan migrate:fresh --seed
    ```

*   **Via Docker puro (Container direto):**
    ```bash
    docker exec -it gerenciador-secretaria-municipal-laravel.test-1 php artisan migrate:fresh --seed
    ```

### Cenário C: Rodar apenas os Seeders de Permissões
Caso você já possua a base de dados migrada, mas precise apenas registrar a permissão `Gerenciar Entidades` e as novas roles no Spatie Permission:

*   **Via Docker Compose puro:**
    ```bash
    docker-compose exec -u sail laravel.test php artisan db:seed --class=PermissionSeeder
    ```

*   **Via Docker puro (Container direto):**
    ```bash
    docker exec -it gerenciador-secretaria-municipal-laravel.test-1 php artisan db:seed --class=PermissionSeeder
    ```
