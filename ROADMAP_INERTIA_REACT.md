# Roadmap: Migração para Inertia.js + React

> **Contexto**: Projeto Laravel 8 com Jetstream/Fortify. A migração converte progressivamente as views Blade em componentes React servidos via Inertia.js, com Vite como bundler.

---

## 🗺️ Visão Geral da Arquitetura

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

## ✅ Fase 1: Limpeza e Reversão (Concluída)
- [x] Remover pasta `/frontend` (projeto Next.js abandonado)
- [x] Atualizar `docker-compose.yml` removendo serviço `frontend`
- [x] Remover `NewsApiController.php` e limpar `routes/api.php`
- [x] Remover referências ao cliente original (PMAC, SEMAS, CODE)

---

## ✅ Fase 2: Instalar e Configurar Inertia.js + React (Concluída)
- [x] Instalar pacote PHP do Inertia
- [x] Registrar middleware `HandleInertiaRequests`
- [x] Remover dependências Vue3, instalar React
- [x] Criar `resources/js/app.jsx` como entry point
- [x] Criar `resources/views/app.blade.php` como layout raiz

---

## ✅ Fase 3: Laravel Mix → Vite (Concluída)
- [x] Instalar e configurar Vite com plugin React
- [x] Criar `vite.config.js`
- [x] Atualizar scripts em `package.json`
- [x] Substituir `mix()` por `@vite()` e `asset()` nos layouts
- [x] Validar build de produção
- [x] Remover dependências do Mix

---

## ✅ Fase 4: Migrar Telas de Autenticação (Concluída)
- [x] `Auth/Login.jsx` — `AuthenticatedSessionController`
- [x] `Auth/Register.jsx` — `RegisteredUserController`
- [x] `Auth/ForgotPassword.jsx` — `PasswordResetLinkController`
- [x] `Auth/ResetPassword.jsx` — `NewPasswordController`
- [x] `Auth/ConfirmPassword.jsx` — `ConfirmablePasswordController`
- [x] `Auth/VerifyEmail.jsx` — `EmailVerificationPromptController`

---

## ✅ Fase 5: Migrar Painel Principal (Concluída)
- [x] `Dashboard.jsx` — `DashboardController`
- [x] `News/` (Index, Create, Show) — `NewsController`
- [x] `People/` (Index, Create, Show) — `PeopleController`
- [x] `Users/` (Index, Create, Edit, Show) — `Admin/UsersController`
- [x] `Ombudsman/` (Index, Show, ReportIndex) — `OmbudsmanController`
- [x] `Revenue/` (Index, Create, Show, ReportIndex) — `RevenueController`
- [x] `Expense/` (Index, Create, Show, ReportIndex) — `ExpenseController`
- [x] `Bidding/` (Index, Create, Show) — `BiddingController`
- [x] `Legislation/` (Index, Create, Show, ReportIndex) — `LegislationController`

---

## 🔄 Fase 6: Migrar Módulos Administrativos Secundários (Em andamento)

> Ordenados por **prioridade de negócio** (maior uso/impacto primeiro).

### Grupo A — Alta Prioridade (CRUD core, usados no dia-a-dia)

- [x] **Contratações Diretas** — `DirectHireController` + `DirectHireWinnerController`
  - Views: `admin.directHire.*`
- [x] **Projetos** — `ProjectController` + `ProjectCategoryController`
  - Views: `admin.project.*`
- [x] **Lideranças** — `LeadershipController`
  - Views: `admin.leadership.*`
- [x] **Unidade** — `UnitController`
  - Views: `admin.unit.*`
- [x] **Relatórios de Contratação** — `HiringReportsController`
  - Views: `admin.hiringReports.*`

### Grupo B — Média Prioridade (Configurações e tabelas de apoio)

- [x] **Tipo de Receita** — `RevenueTypeController`
  - Views: `admin.revenue.type_*`
- [x] **Tipo de Despesa** — `TypeExpenseController`
  - Views: `admin.expense.type_*`
- [x] **Tipo de Acesso** — `TypeAccessController`
- [x] **Tipo de Solicitação** — `TypeRequestController`
- [x] **Unidade de Conservação** — `UnitConservationController` + `ConservationUnitController`
- [x] **Departamento** — `DepartamentController`
- [x] **Ocupação** — `OccupationController`
- [x] **Organização** — `OrganizationController`

### Grupo C — Baixa Prioridade (Conteúdo do site público / auxiliares)

- [x] **Notificações** — `NotificationController`
- [x] **Galeria** — `GalleryController`
- [ ] **Post** — `PostController`
- [ ] **FAQ** — `FAQController`
- [ ] **Banner** — `BannerController`
- [ ] **Legislação (aux)** — `LegislationBondController`, `LegislationCategoryController`, `LegislationSituationController`, `LegislationSubjectController`
- [ ] **Arquivo** — `FileController`
- [ ] **Shortcut Web** — `ShortcutWebController`
- [ ] **Relatório Gerencial** — `ManagementReportController`

### Grupo D — Manter em Blade por ora (Páginas estáticas / template site público)

> Conforme decisão do projeto, as views do site público (`/web/**`) serão refeitas do zero no futuro. Não migrar agora.

- ⏸️ `PagesController` — páginas de exemplo do template (account, blog, etc.)
- ⏸️ Controllers Web: `HomeWebController`, `InstitutionalWebController`, `ServicesWebController`, `MyEnvironmentWebController`, `TransparencyWebController`, `PublicationWebController`

---

## 📌 Regras de Migração

- Cada `return view('admin.*')` deve virar `return Inertia::render('Módulo/Página', [...])`
- Criar o componente React correspondente em `resources/js/Pages/`
- Usar `useForm` do `@inertiajs/inertia-react` em formulários
- Rodar `npm run build` após cada migração de módulo
- Rodar `php artisan test` para garantir ausência de regressões

---

## 📋 Fase 7: Bootstrap → Tailwind CSS (Futuro — após Fase 6 concluída)

> ✅ **Decisão confirmada:** Bootstrap será substituído por **Tailwind CSS + Shadcn/ui**.
> A remoção só deve ocorrer **depois** que todos os módulos estiverem em React.

### Por que substituir?
- Bootstrap adiciona ~200KB de CSS não utilizado nos componentes React
- Classes Bootstrap acoplam os componentes React a um sistema de design legado
- Tailwind permite CSS zero-runtime, purge automático e consistência com o ecossistema React moderno
- Shadcn/ui entrega componentes acessíveis, sem estilo imposto, prontos para customização

### Plano de remoção incremental

**Etapa 7.1 — Auditoria**
- [ ] Mapear todos os componentes React que usam classes Bootstrap (`btn`, `form-control`, `card`, `col-`, `row`, etc.)
- [ ] Identificar componentes JS do Bootstrap em uso (Modals, Dropdowns, Tooltips)
- [ ] Mapear tokens de design atuais (cores, espaçamentos) para migrar ao `tailwind.config.js`

**Etapa 7.2 — Instalar Tailwind + Shadcn/ui**
- [ ] Instalar `tailwindcss`, `@tailwindcss/forms`, `@tailwindcss/typography` no pipeline Vite
- [ ] Configurar `tailwind.config.js` com purge para `resources/js/**` e `resources/views/**`
- [ ] Instalar `shadcn/ui` (ou `@radix-ui/react-*` + `class-variance-authority`) para componentes acessíveis

**Etapa 7.3 — Migração componente a componente**
- [ ] Criar design tokens (cores, espaçamentos) alinhados ao novo design
- [ ] Migrar `AdminLayout.jsx` para Tailwind
- [ ] Migrar cada página React progressivamente (começar pelas mais simples)
- [ ] Remover imports do Bootstrap dos layouts Blade

**Etapa 7.4 — Limpeza final**
- [ ] Remover `bootstrap` do `package.json`
- [ ] Remover arquivos `public/css/core.css`, `public/vendors/`, etc.
- [ ] Remover referências a Bootstrap nos layouts Blade legados
- [ ] Validar build sem Bootstrap

> [!WARNING]
> Não iniciar a Fase 7 antes de concluir a Fase 6. Remover Bootstrap antes de migrar todos os módulos quebrará as views Blade ainda ativas.

---

## 📋 Fase 8: Melhorias no Sistema de Permissões (Médio prazo)

> ✅ **Decisão confirmada:** Manter **Spatie Laravel-Permission**. Implementar as melhorias de Enum + compartilhamento com React.
> Ver análise completa em `docs/spatie-analysis.md`.

**Etapa 8.1 — Criar Enum de Permissões**
- [ ] Criar `app/Enums/Permission.php` com todas as permissões como enum PHP 8.1
- [ ] Substituir strings hardcoded nos controllers por `Permission::ENUM->value`
- [ ] Atualizar seeders de permissões para usar os valores do enum

**Etapa 8.2 — Compartilhar permissões com React**
- [ ] Atualizar `HandleInertiaRequests::share()` para incluir permissões do usuário
- [ ] Criar hook `usePermission()` no React para checar permissões no frontend
- [ ] Aplicar controle de UI (mostrar/esconder botões) baseado nas permissões recebidas

**Etapa 8.3 — Melhorar tratamento de não-autorizado**
- [ ] Substituir `return view('pages.not-authorized')` por `abort(403)` nos controllers
- [ ] Criar página `403.jsx` em Inertia para tratar o erro de forma elegante

---

## 📌 Notas Importantes

- **Docker:** Usar sempre `docker-compose exec -u sail laravel.test` para PHP/Artisan. Nunca usar `./vendor/bin/sail`.
- **Git:** Commits são responsabilidade exclusiva do usuário. A IA prepara apenas a mensagem.
- **TDD:** Seguir o fluxo Red → Green antes de cada implementação.
- **Dados compartilhados globais** (usuário, permissões, flash) via `HandleInertiaRequests::share()`.
- **Livewire**: Coexiste temporariamente, será substituído por React progressivamente.
- **Bootstrap**: Manter até conclusão da Fase 6. Ver Fase 7 para plano de remoção.
- **Spatie Permission**: Manter. Ver `docs/spatie-analysis.md` para análise completa e melhorias sugeridas.
