# Plano de Migração: Laravel Mix → Vite

## Visão geral
Migrar o pipeline de frontend do Laravel Mix para Vite, mantendo a arquitetura atual de backend Laravel 8 + Inertia + React. O plano é incremental: primeiro o app React/Inertia, depois os assets legados e, finalmente, a remoção do Mix.

## Etapa 1: Auditoria do estado atual
- Listar todos os usos de `mix('...')` no projeto.
- Identificar entradas atuais em `webpack.mix.js`.
- Confirmar a entrada principal React: `resources/js/app.jsx`.
- Mapear assets críticos de CSS/JS usados pelo admin e pelo painel público.

## Etapa 2: Preparar o novo build com Vite
1. Instalar dependências necessárias.
   - `vite`
   - `@vitejs/plugin-react`
   - `@vitejs/plugin-legacy` (opcional)
   - `postcss`
   - `autoprefixer`
   - `@tailwindcss/forms` / `@tailwindcss/typography` se necessário
2. Criar `vite.config.js`.
3. Definir as entradas:
   - `resources/js/app.jsx`
   - `resources/scss/core.scss` ou `resources/css/app.css`
4. Adicionar scripts ao `package.json`:
   - `dev`: `vite`
   - `build`: `vite build`
   - `preview`: `vite preview`

## Etapa 3: Substituir Mix por Vite nos templates principais
- Alterar `resources/views/app.blade.php` para usar `@vite()` em vez de `mix()`.
- Expandir para outros layouts principais quando o app React estiver estável.
- Para assets legados, usar `asset()` sem Mix até a migração.

## Etapa 4: Testar o app React/Inertia
- Rodar `npm install`.
- Rodar `npm run dev` e verificar no navegador.
- Confirmar que o Inertia app renderiza corretamente.
- Testar navegação e formulários principais.

## Etapa 5: Migrar CSS e scripts legados
- Migrar os principais estilos do admin para serem processados pelo Vite.
- Migrar scripts `resources/js/core/*` que ainda são usados.
- Substituir `mix('css/...')` e `mix('js/...')` por `@vite()` ou caminhos estáticos.
- Garantir que o painel continue funcionando durante a migração.

## Etapa 6: Validar build de produção
- Rodar `npm run build`.
- Verificar saída no diretório `public/build`.
- Confirmar uso de `@vite` em produção.
- Revisar se o build gerou CSS e JS corretamente.

## Etapa 7: Remover Mix e limpeza final
- Remover `laravel-mix`, `laravel-mix-purgecss`, `webpack`, `sass-loader`, `css-loader`, etc. do `package.json`.
- Excluir `webpack.mix.js` se não for mais necessário.
- Eliminar referências restantes ao `mix()` nos templates.
- Atualizar documentação e comandos de desenvolvimento.

## Verificação
- `npm run dev` abre sem erros e HMR funciona.
- `npm run build` completa sem falhas.
- As páginas Inertia críticas carregam no browser.
- `mix()` não aparece mais em templates principais.
- O projeto Docker/Sail roda com o novo pipeline.

## Notas de migração incremental
- Phase 1: app React/Inertia.
- Phase 2: estilos e scripts legados.
- Phase 3: limpeza de Mix.

## Comandos sugeridos
- `npm install`
- `npm run dev`
- `npm run build`
- `php artisan view:clear`
- `php artisan config:clear`
- `php artisan route:clear`

## Riscos
- Templates Blade legacy que dependem de `mix()` para muitos assets.
- Componentes Vue ou outras integrações não compatíveis podem exigir ajustes.
- Necessidade de manter `asset()` para arquivos de vendor não migrados.

## Checklist do Plano de Migração
- [ ] Mapear todos os arquivos e templates que usam `mix()`.
- [ ] Identificar entradas de build em `webpack.mix.js`.
- [ ] Confirmar o ponto de entrada React `resources/js/app.jsx`.
- [ ] Instalar `vite`, `@vitejs/plugin-react`, `postcss`, `autoprefixer` e plugins necessários.
- [ ] Criar `vite.config.js` com configurações de React e assets.
- [ ] Registrar scripts `dev`, `build` e `preview` em `package.json`.
- [ ] Atualizar `resources/views/app.blade.php` para usar `@vite()`.
- [ ] Testar `npm run dev` e navegar no app Inertia.
- [ ] Executar `npm run build` e validar saída em `public/build`.
- [ ] Migrar gradualmente CSS e scripts legados para Vite.
- [ ] Remover dependências e arquivos do Mix.
- [ ] Verificar que `mix()` não permanece em templates críticos.
- [ ] Garantir que o Docker/Sail funcione com o novo pipeline.
