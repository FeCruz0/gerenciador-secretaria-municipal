# Gerenciador Secretaria Municipal

Projeto Laravel 8 com frontend **Inertia.js + React** e pipeline de build **Vite**. Desenvolvido originalmente como sistema de gestão para secretaria municipal, atualmente sendo refatorado como projeto de portfólio.

## Descrição

Aplicação de gestão administrativa municipal com painel de controle moderno, suporte a autenticação, permissões granulares (Spatie Permission) e dashboards. O backend é Laravel 8 e o frontend usa Inertia.js com React, compilados via Vite.

> Projeto legado em processo de modernização: remoção de referências ao cliente original, migração de Blade para Inertia/React e padronização da infraestrutura com Docker Compose puro.

## Stack principal

- PHP 8.1+
- Laravel 8 + Fortify + Jetstream
- Inertia.js + React 17
- Vite (migração do Laravel Mix concluída)
- Bootstrap 5 (template admin legado)
- Spatie Permission
- Docker Compose (sem Laravel Sail)

## Status atual

### ✅ Concluído
- Migração de Laravel Mix → **Vite** completa
- Todas as views de **autenticação** migradas para Inertia + React:
  - Login, Register, ForgotPassword, ResetPassword, ConfirmPassword, VerifyEmail
- Painel principal migrado: Dashboard, Notícias, Pessoas, Usuários, Ouvidoria, Receita, Despesa, Licitações, Legislação
- Remoção de referências ao cliente original (PMAC, SEMAS, CODE)
- Infraestrutura padronizada com **docker-compose puro** (Sail descontinuado)

### 🔄 Em andamento
- Migração dos módulos administrativos secundários para Inertia + React
- Ver `ROADMAP_INERTIA_REACT.md` para o checklist completo

## Pré-requisitos

- Docker & Docker Compose

## Instalação

1. Copie o arquivo de ambiente:

   ```bash
   cp .env.example .env
   ```

2. Suba os containers:

   ```bash
   docker-compose up -d
   ```

3. Instale dependências e prepare o ambiente:

   ```bash
   docker-compose exec -u sail laravel.test composer install
   docker-compose exec laravel.test npm install
   docker-compose exec -u sail laravel.test php artisan key:generate
   docker-compose exec -u sail laravel.test php artisan migrate --seed
   ```

## Execução

### Desenvolvimento

```bash
docker-compose up -d
docker-compose exec laravel.test npm run dev
```

### Build de produção

```bash
docker-compose exec laravel.test npm run build
```

### Testes

```bash
docker-compose exec -T -u sail laravel.test php artisan test
```

## Scripts npm

- `npm run dev` — inicia o servidor Vite com HMR
- `npm run build` — gera os assets de produção em `public/build/`

## Estrutura importante

- `resources/js/app.jsx` — ponto de entrada React/Inertia
- `resources/js/Pages/` — componentes React por módulo
- `resources/views/app.blade.php` — layout raiz Inertia
- `vite.config.js` — configuração Vite
- `docker-compose.yml` — infraestrutura Docker

## Credenciais de desenvolvimento

- **Admin:** `admin@admin.com` / `admin`

## Git

Repositório: `https://github.com/FeCruz0/gerenciador-secretaria-municipal`

## Documentação adicional

- `ROADMAP_INERTIA_REACT.md` — roadmap de migração Inertia + React (principal)
- `docs/roadmap.md` — prioridades e evolução do projeto
- `docs/vite-migration-plan.md` — plano de migração Mix → Vite (concluído)
- `LOGIN_PANEL_FIX.md` — correção do painel de auth pós-Vite

---

> **Regras de IA:** Consulte `.cursorrules` antes de qualquer alteração. Git commits são responsabilidade exclusiva do usuário.
