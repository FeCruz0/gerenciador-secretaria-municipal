# Roadmap de Migração e Evolução

## Objetivo
Migrar o frontend atual de Laravel Mix para Vite em um projeto Laravel 8 com Inertia + React, preservando a funcionalidade atual do painel administrativo e preparando a base para melhorias de performance e novos módulos.

## Prioridades

### Prioridade 1: Preparação da migração para Vite
1. Auditar o uso de `mix()` em todos os templates Blade e componentes.
2. Instalar e configurar `vite` com plugin React.
3. Atualizar `package.json` para scripts de Vite.
4. Configurar `vite.config.js` com entrada para `resources/js/app.jsx`.
5. Ajustar os layouts Blade principais para usar `@vite()` em vez de `mix()`.

### Prioridade 2: Estabilizar o app React/Inertia
1. Garantir que `resources/js/app.jsx` funcione como entrada Vite.
2. Testar HMR e carregamento de páginas Inertia.
3. Migrar gradualmente CSS e scripts legados para o pipeline Vite.
4. Manter os assets legados em `asset()` enquanto a migração ocorre.

### Prioridade 3: Performance e limpeza pós-migração
1. Executar build de produção com Vite.
2. Remover dependências e arquivos do Mix.
3. Verificar e migrar todos os templates restantes que usam `mix()`.
4. Limpar CSS e JS não utilizados.

### Prioridade 4: Funcionalidades de alto impacto
1. Autenticação e autorização de administradores via Jetstream/Fortify com Inertia.
2. Correção de N+1 queries nos controllers críticos.
3. Cache de consultas e uso do Redis no Docker.
4. Modelos de conteúdo para notícias, eventos, documentos e configurações do site.
5. Evolução para portal da transparência e ouvidoria.

## Observações
- A migração para Vite deve ser incremental, começando pelo app React/Inertia.
- O foco inicial não é migrar para Next.js; Vite é a alternativa mais adequada para este projeto.
- Os templates Blade com CSS e JS legacy podem ser mantidos até a migração completa.
## Checklist do Roadmap
- [ ] Auditar todos os usos de `mix()` no projeto.
- [ ] Instalar e configurar `vite` com plugin React.
- [ ] Atualizar `package.json` para scripts de Vite.
- [ ] Configurar `vite.config.js` e entradas de build.
- [ ] Substituir `mix()` por `@vite()` nos layouts principais.
- [ ] Validar HMR e a renderização do app Inertia.
- [ ] Migrar CSS e scripts legados gradualmente.
- [ ] Executar build de produção com Vite.
- [ ] Remover dependências do Mix e limpar arquivos antigos.
- [ ] Priorizar auth, N+1 e cache após a migração estar estável.
- [ ] Planejar evolução para notícias, eventos, documentos e transparência.