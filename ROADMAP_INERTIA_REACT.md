# Roadmap: Migração para Inertia.js + React

> **Contexto**: O projeto usa Laravel 8 com Jetstream, que já possui o Inertia.js instalado (stack Vue3).
> A migração consiste em: desfazer a abordagem API + Next.js, trocar Vue3 por React no Inertia,
> e converter progressivamente as views Blade em componentes React.

---

## 🗺️ Visão Geral da Nova Arquitetura

```
Navegador
    ↓  requisição HTTP
Laravel (rotas web.php)
    ↓  Inertia::render('NomeDaPage', ['dados' => $dados])
React Component (resources/js/Pages/...)
    ↓  renderizado no cliente com dados do Laravel
```

**Não há API REST separada. Não há CORS. Não há token JWT.**
Autenticação via sessão do Laravel, exatamente como com Blade.

---

## ⚠️ O que DESFAZER (da abordagem API + Next.js)

> Estes itens foram criados durante a tentativa anterior e devem ser removidos/revertidos.

- [x] **Remover pasta `/frontend`** — contém o projeto Next.js que não será mais utilizado
- [x] **Remover serviço `frontend` do `docker-compose.yml`** — voltar para 1 único container da app
- [x] **Remover `frontend/Dockerfile.dev`** e arquivos relacionados (já serão removidos com a pasta)
- [x] **Remover `/app/Http/Controllers/Api/NewsApiController.php`** — controller de API REST criado para Next.js
- [x] **Limpar as rotas adicionadas em `routes/api.php`** — remover rotas `/news` e `/news/{id}`
- [x] **Remover `.dockerignore` da raiz** — não é mais necessário com 1 container

---

## 📋 Checklist de Migração

### Fase 1: Limpeza e Reversão
- [x] Remover pasta `/frontend` e parar o serviço no Docker
- [x] Atualizar `docker-compose.yml` removendo o serviço `frontend`
- [x] Remover `NewsApiController.php` e limpar `routes/api.php`

---

### Fase 2: Instalar e Configurar Inertia.js + React

> O projeto já tem `@inertiajs/inertia` instalado, mas na versão para Vue3.
> Vamos trocar para a versão React.

- [x] **Instalar pacote PHP do Inertia**:
  ```bash
  docker-compose exec -u sail laravel.test composer require inertiajs/inertia-laravel
  ```

- [x] **Registrar middleware `HandleInertiaRequests`** em `app/Http/Kernel.php`:
  ```php
  // Em $middlewareGroups['web']:
  \App\Http\Middleware\HandleInertiaRequests::class,
  ```

- [x] **Publicar o middleware**:
  ```bash
  docker-compose exec -u sail laravel.test php artisan inertia:middleware
  ```

- [x] **Remover dependências Vue3** do `package.json`:
  - `@inertiajs/inertia-vue3`
  - `@vue/compiler-sfc`
  - `vue`
  - `vue-loader`

- [x] **Instalar dependências React** no `package.json`:
  ```bash
  docker-compose exec -u sail laravel.test npm install @inertiajs/inertia @inertiajs/react react react-dom
  docker-compose exec -u sail laravel.test npm install --save-dev @babel/preset-react
  ```

---

### Fase 3: Configurar Bundler (Laravel Mix → Vite ou Mix com React)

> O projeto usa `laravel-mix`. Vamos configurá-lo para compilar JSX.

- [x] **Atualizar `webpack.mix.js`** para suportar React/JSX:
  ```js
  mix.js('resources/js/app.jsx', 'public/js')
     .react()  // habilita transformação JSX
     .postCss('resources/css/app.css', 'public/css');
  ```

- [x] **Criar `resources/js/app.jsx`** — entry point do Inertia + React:
  ```jsx
  import { createRoot } from 'react-dom/client';
  import { createInertiaApp } from '@inertiajs/react';

  createInertiaApp({
    resolve: (name) => {
      const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true });
      return pages[`./Pages/${name}.jsx`];
    },
    setup({ el, App, props }) {
      createRoot(el).render(<App {...props} />);
    },
  });
  ```

- [x] **Criar template raiz Blade** em `resources/views/app.blade.php`:
  ```html
  <!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ config('app.name') }}</title>
      <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>
      @inertia
      <script src="{{ mix('js/app.js') }}" defer></script>
  </body>
  </html>
  ```

- [x] **Compilar os assets**:
  ```bash
  docker-compose exec -u sail laravel.test npm run dev
  ```

---

### Fase 4: Migrar Controllers de Blade → Inertia

> Os controllers atuais retornam views Blade. Cada `return view(...)` será convertido para `return Inertia::render(...)`.

#### Exemplo de migração (NewsController):
```php
// ANTES (Blade):
return view('admin.news.news_index', compact('news'));

// DEPOIS (Inertia + React):
return Inertia::render('News/Index', [
    'news' => $news
]);
```

- [x] **Dashboard** (`DashboardController`) — página inicial após login
- [x] **Notícias** (`NewsController`) — index, create, show, edit
- [x] **Pessoas** (`PeopleController`)
- [x] **Usuários** (`Admin/UsersController`)
- [ ] **Legislação** (`LegislationController`)
- [ ] **Licitações** (`BiddingController`)
- [ ] **Receitas** (`RevenueController`)
- [ ] **Despesas** (`ExpenseController`)
- [x] **Ouvidoria** (`OmbudsmanController`)
- [ ] **Demais controllers** (migração progressiva)

---

### Fase 5: Criar Componentes React

> Para cada `Inertia::render('News/Index', ...)` no controller, deve existir um arquivo em `resources/js/Pages/`.

- [x] **Criar estrutura de pastas**:
  ```
  resources/js/
  ├── app.jsx
  ├── Pages/
  │   ├── Dashboard.jsx
  │   ├── News/
  │   │   ├── Index.jsx
  │   │   ├── Create.jsx
  │   │   └── Show.jsx
  │   ├── People/
  │   │   ├── Index.jsx
  │   │   ├── Show.jsx
  │   │   └── Create.jsx
  │   ├── Users/
  │   │   ├── Index.jsx
  │   │   ├── Create.jsx
  │   │   └── Edit.jsx
  │   └── Ombudsman/
  │       ├── Index.jsx
  │       ├── Show.jsx
  │       └── ReportIndex.jsx
  └── Components/
      └── Layout/
          └── AdminLayout.jsx
  ```

- [x] **Criar Layout Admin** (`AdminLayout.jsx`) — sidebar, header, footer
- [x] **Migrar página Dashboard**
- [x] **Migrar páginas de Notícias**
- [x] **Migrar páginas de Pessoas, Usuários e Ouvidoria**
- [ ] **Migrar demais páginas progressivamente** (Legislação, Licitações, Receitas, Despesas)

---

### Fase 6: Autenticação

> Com Inertia, a autenticação via sessão do Laravel funciona nativamente. Basta adaptar as rotas de login.

- [ ] **Configurar rotas de auth** apontando para componentes React:
  ```php
  Route::get('/login', fn() => Inertia::render('Auth/Login'))->name('login');
  ```
- [ ] **Criar `Pages/Auth/Login.jsx`** com formulário de login usando `useForm` do Inertia
- [ ] **Criar `Pages/Auth/Register.jsx`** se necessário

---

## 🚀 Ordem de Execução Recomendada

| # | Ação | Estimativa |
|---|------|-----------|
| 1 | Limpeza: remover frontend, atualizar docker-compose | 15 min |
| 2 | Instalar Inertia PHP + React, configurar middleware | 30 min |
| 3 | Configurar Mix para JSX, criar `app.jsx` e `app.blade.php` | 30 min |
| 4 | Compilar e verificar que a página carrega sem erros | 15 min |
| 5 | Migrar Dashboard (primeira página de teste) | 1h |
| 6 | Criar Layout Admin reutilizável | 2h |
| 7 | Migrar demais páginas progressivamente | ongoing |

---

## 📌 Notas Importantes

- **Livewire existente**: O projeto usa Livewire (`livewire/livewire ^2.5`). Com Inertia, o Livewire pode **coexistir** temporariamente, mas será substituído por componentes React no estado final.
- **Manter `routes/web.php`**: As rotas permanecem em `web.php`. Apenas o retorno dos controllers muda.
- **Dados compartilhados**: Dados globais (usuário logado, permissões, flash messages) devem ser compartilhados via `HandleInertiaRequests::share()`.
- **Formulários**: Usar o hook `useForm` do Inertia para submissão de formulários (sem fetch/axios manual).
