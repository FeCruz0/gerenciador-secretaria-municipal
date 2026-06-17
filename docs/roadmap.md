# Roadmap de Migração e Evolução

## Objetivo
Modernizar o sistema de gestão municipal: migrar o frontend de Blade para Inertia + React com Vite, remover referências ao cliente original, e preparar o projeto como portfólio técnico.

---

## ✅ Prioridade 1: Migração para Vite (Concluída)
- [x] Auditar e remover todos os usos de `mix()` nos templates
- [x] Instalar e configurar `vite` com plugin React
- [x] Atualizar `package.json` para scripts de Vite
- [x] Configurar `vite.config.js` com entrada `resources/js/app.jsx`
- [x] Substituir `mix()` por `@vite()` e `asset()` nos layouts principais
- [x] Validar HMR e renderização do app Inertia
- [x] Executar build de produção com Vite
- [x] Remover dependências e arquivos do Mix

---

## ✅ Prioridade 2: Migração Auth + Painel Principal (Concluída)
- [x] Login, Register, ForgotPassword, ResetPassword, ConfirmPassword, VerifyEmail → Inertia/React
- [x] Dashboard, Notícias, Pessoas, Usuários, Ouvidoria → Inertia/React
- [x] Receita, Despesa, Licitações, Legislação → Inertia/React

---

## ✅ Prioridade 3: Limpeza de Referências ao Cliente Original (Concluída)
- [x] Remover referências PMAC, SEMAS, CODE do código da aplicação
- [x] Atualizar deploy.php com novo repositório GitHub
- [x] Neutralizar UnitSeeder com dados do cliente
- [x] Renomear rota `/publicacoessemas` → `/publicacoes`
- [x] Remover logo CODE do Login.jsx

---

## 🔄 Prioridade 4: Migrar Módulos Administrativos Secundários (Em andamento)
Ver checklist detalhado em `ROADMAP_INERTIA_REACT.md` — Fase 6.

### Ordem sugerida:
1. [x] Contratações Diretas (`DirectHireController` + `DirectHireWinnerController`)
2. Projetos (`ProjectController`)
3. Lideranças (`LeadershipController`)
4. Unidade (`UnitController`)
5. Relatórios de Contratação (`HiringReportsController`)
6. Tabelas auxiliares (Tipos, Departamento, Ocupação, Organização)

---

## 📋 Prioridade 5: Melhorias Técnicas (Futuro)
- [ ] Correção de N+1 queries nos controllers críticos
- [ ] Cache de consultas e Redis no Docker
- [ ] Tipagem estrita PHP 8.1 nos controllers migrados
- [ ] Compartilhar permissões Spatie via `HandleInertiaRequests::share()`
- [ ] Remoção do Livewire (substituído por React)

---

## 📋 Prioridade 6: Site Público (Futuro — Não migrar agora)
> As views do site público (`/web/**`) serão refeitas do zero com novo template.
- [ ] Novo template para o site público
- [ ] Remover views estáticas legadas após novo template pronto