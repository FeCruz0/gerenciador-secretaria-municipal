# Gerenciador Secretaria Municipal

Projeto Laravel 8 com frontend Inertia + React e migração em andamento de Laravel Mix para Vite.

## Descrição

Aplicação de gestão para secretaria municipal com interface moderna, suporte a autenticação, permissões e dashboards. O backend é Laravel 8 e o frontend usa Inertia.js com React.
Projeto legado de um trabalho anterior que estou atualizando para estudo e portfolio.

## Stack principal

- PHP 8.1+
- Laravel 8
- Inertia.js
- React 17
- Vite (migração em andamento)
- Tailwind CSS
- Jetstream + Sanctum
- Spatie Permission
- Laravel Sail / Docker opcional

## Status atual

- `vite.config.js` criado e configurado
- `resources/views/app.blade.php` atualizado para usar `@vite('resources/js/app.jsx')`
- `package.json` contém scripts Vite e dependências para React + Laravel Vite Plugin
- O projeto ainda possui referências antigas a `mix()` em algumas views
- `webpack.mix.js` e assets Mix continuam presentes para evitar quebra até a migração completa

## Pré-requisitos

- PHP 8.1+
- Composer
- Node.js 18+ / npm
- Docker & Docker Compose (opcional)

## Instalação

1. Copie o arquivo de ambiente:

   ```bash
   cp .env.example .env
   ```

2. Instale dependências PHP:

   ```bash
   composer install
   ```

3. Instale dependências Node:

   ```bash
   npm install
   ```

4. Gere a chave de aplicação:

   ```bash
   php artisan key:generate
   ```

## Execução

### Desenvolvimento

```bash
npm run dev
php artisan serve
```

### Build de produção

```bash
npm run build
php artisan vendor:publish --tag=laravel-assets
```

## Scripts npm

- `npm run dev` — inicia o servidor Vite
- `npm run build` — gera os assets de produção
- `npm run preview` — pré-visualiza o build de produção

## Observações de migração

- Ainda existem views que usam `mix('...')` e `asset(mix('...'))`.
- Manter `webpack.mix.js` e arquivos de build antigos até migrar todas as referências.
- Quando a migração estiver completa, remova o Mix e `mix-manifest.json`.

## Estrutura importante

- `resources/js/app.jsx` — ponto de entrada React
- `resources/views/app.blade.php` — layout principal Inertia
- `vite.config.js` — configuração Vite
- `webpack.mix.js` — configuração legada Mix

## Git

Já existe `.gitignore` configurado para ignorar `node_modules`, `vendor`, `public/hot`, `storage`, `.env` e outros arquivos de build.

## Documentação adicional

- `docs/roadmap.md`
- `ROADMAP_INERTIA_REACT.md`

---

> Use este `README.md` como base e atualize conforme o projeto avançar na migração para Vite e na limpeza dos assets legados.
