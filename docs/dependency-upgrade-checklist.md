# Checklist de Atualização de Dependências

Este documento detalha o checklist passo a passo para atualizar o **Laravel** (para a versão **10.x**) e todas as dependências do PHP (Composer) e do Javascript (NPM) para suas versões estáveis mais atuais compatíveis com o ambiente (PHP 8.1.33 e Node 22.14).

---

## 📋 Fase 1: Preparação do Ambiente
- [ ] Garantir que está na branch de feature dedicada (`feat/update-dependencies`).
- [ ] Verificar se o contêiner Docker está rodando e acessível (`docker-compose ps`).
- [ ] Confirmar as versões de PHP e Node no ambiente:
  - PHP: `8.1.33` (suporta até Laravel 10.x).
  - Node: `22.14.0` (suporta Vite 5/6 e React 18/19).
- [ ] Rodar os testes atuais para registrar a linha de base de erros conhecidos (`php artisan test`).

---

## 📦 Fase 2: Atualização do PHP & Composer (Laravel 10.x)

### 2.1 Ajustes no `composer.json`
- [ ] Alterar as dependências principais no bloco `"require"`:
  - `"laravel/framework": "^10.0"`
  - `"laravel/jetstream": "^4.0"`
  - `"laravel/sanctum": "^3.2"`
  - `"laravel/tinker": "^2.8"`
  - `"spatie/laravel-permission": "^6.0"`
  - `"owen-it/laravel-auditing": "^13.0"`
  - `"barryvdh/laravel-dompdf": "^2.0"`
  - `"tucker-eric/eloquentfilter": "^4.0"`
  - `"dyrynda/laravel-cascade-soft-deletes": "^4.2"`
  - `"doctrine/dbal": "^3.6"`
  - `"livewire/livewire": "^2.12"` (mantido na v2 para evitar quebras nos templates Blade legados)
  - Adicionar `"tightenco/ziggy": "^2.0"`
  - Remover `"fideloper/proxy"` e `"fruitcake/laravel-cors"`.
- [ ] Alterar as dependências de desenvolvimento no bloco `"require-dev"`:
  - `"nunomaduro/collision": "^7.0"`
  - `"spatie/laravel-ignition": "^2.0"` (substitui o antigo `facade/ignition`)
  - `"laravel/sail": "^1.20"`
  - `"mockery/mockery": "^1.5"`
  - `"phpunit/phpunit": "^9.6"` (mantido temporariamente na v9 para compatibilidade retroativa com os testes existentes antes de migrar para a v10)
  - Remover `"facade/ignition"`.

### 2.2 Alterações em Arquivos de Configuração e Middlewares
- [ ] **`app/Http/Middleware/TrustProxies.php`**:
  - Atualizar o `use` para estender `Illuminate\Http\Middleware\TrustProxies` no lugar da classe descontinuada do `Fideloper`.
- [ ] **`app/Http/Kernel.php`**:
  - Substituir `\Fruitcake\Cors\HandleCors::class` por `\Illuminate\Http\Middleware\HandleCors::class`.
- [ ] **`config/cors.php`**:
  - Garantir que existe o arquivo de configuração de CORS padrão do Laravel, publicando-o se necessário: `php artisan vendor:publish --tag=laravel-cors`.

### 2.3 Atualização dos Pacotes
- [ ] Rodar a atualização do Composer de dentro do contêiner Docker:
  ```bash
  docker-compose exec -u sail laravel.test composer update --no-audit
  ```
- [ ] Limpar todas as caches do framework para registrar os novos service providers:
  ```bash
  docker-compose exec -u sail laravel.test php artisan optimize:clear
  ```

---

## 🎨 Fase 3: Atualização do Javascript & NPM (React 18 & Vite 5)

### 3.1 Ajustes no `package.json`
- [ ] Remover os pacotes Inertia descontinuados:
  - `@inertiajs/inertia`
  - `@inertiajs/inertia-react`
  - `@inertiajs/progress`
- [ ] Instalar as versões modernas consolidadas do Inertia:
  - `@inertiajs/react` (`^1.2` ou `^2.0`)
- [ ] Atualizar a versão do React:
  - `react`: `^18.2.0`
  - `react-dom`: `^18.2.0`
- [ ] Atualizar o bundler e plugins do Vite:
  - `vite`: `^5.0.0`
  - `laravel-vite-plugin`: `^1.0.0`
  - `@vitejs/plugin-react`: `^4.2.0`
- [ ] Atualizar o ecossistema do Tailwind CSS:
  - `tailwindcss`: `^3.4.0`
  - `autoprefixer`: `^10.4.16`
  - `postcss`: `^8.4.32`

### 3.2 Ajustes de Código no Frontend (Migração Inertia v1+)
- [ ] **`resources/js/app.jsx`**:
  - Alterar a importação de `createInertiaApp` para:
    ```javascript
    import { createInertiaApp } from '@inertiajs/react'
    ```
  - Remover a importação de `@inertiajs/progress` e inicializar o indicador de progresso nativo integrado no `@inertiajs/react` se necessário.
- [ ] **Componentes React (ex: `AdminLayout.jsx` e páginas em `resources/js/Pages`)**:
  - Alterar as importações de `Link`, `usePage`, `router` ou `Inertia` de `@inertiajs/inertia-react` ou `@inertiajs/inertia` para `@inertiajs/react`.
- [ ] **`vite.config.js`**:
  - Atualizar se houver opções depreciadas da versão 4 do Vite.

### 3.3 Instalação & Build
- [ ] Executar a instalação dos novos pacotes NPM localmente:
  ```bash
  npm install
  ```
- [ ] Testar a compilação em desenvolvimento:
  ```bash
  npm run dev
  ```
- [ ] Executar o build de produção dos assets:
  ```bash
  npm run build
  ```

---

## 🧪 Fase 4: Validação & Resolução de Erros de Teste

- [ ] Executar a suite de testes automatizados:
  ```bash
  docker-compose exec -u sail laravel.test php artisan test
  ```
- [ ] Resolver falhas conhecidas de testes pré-existentes:
  - **`ExampleTest`**: Adicionar o trait `RefreshDatabase` ou corrigir o teste para não depender de tabelas inexistentes sem migração em memória.
  - **`ProfileInformationTest`**: Corrigir a comparação de strings considerando o mutator `setNameAttribute` que aplica `mb_strtoupper` no nome do usuário.
  - **`DeleteUser`**: Tratar o método `deleteProfilePhoto()` se o trait `HasProfilePhoto` estiver desabilitado no `User.php`.
- [ ] Verificar visualmente no navegador se a tela de login (`/login`) e o painel administrativo (`/dashboard`) renderizam sem erros de Javascript ou CSS.
