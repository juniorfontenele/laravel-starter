# Laravel 12 – Basic Starter Kit

> Um ponto de partida simples, focado em Blade, com ferramentas modernas de produtividade, qualidade de código e um pipeline básico de CI.

---

## Introdução

Este Starter Kit para **Laravel 12** foi pensado para quem quer iniciar um projeto rápido, em Blade (sem Livewire/Vue/React), já com:

- Padrões de qualidade (Pint, PHPStan/Larastan, Rector, ESLint, Prettier, Tailwind v4)
- Scripts de desenvolvimento unificados (PHP + Queue + Logs + Vite em um só comando)
- Fluxos de CI prontos (tests + lint) via GitHub Actions
- Localização PT-BR incluída

Status: **Work in Progress** – melhorias contínuas, feedback bem-vindo.

---

## Funcionalidades Incluídas

- Estrutura de testes (Pest) e exemplos iniciais
- Banco SQLite pronto por padrão (criado automaticamente no setup)
- Localização PT-BR
- Visualização de logs pela interface (Log Viewer)

---

## Pacotes PHP Instalados

Produção:
- `laravel/framework` – Core Laravel 12
- `opcodesio/log-viewer` – Interface para visualização de logs

Desenvolvimento / Qualidade:
- `barryvdh/laravel-debugbar` – Debug de requisições
- `barryvdh/laravel-ide-helper` – Helpers para autocompletar IDE
- `larastan/larastan` – Análise estática (PHPStan para Laravel)
- `rector/rector` + `driftingly/rector-laravel` – Refactors/upgrades automatizados
- `laravel/pint` – Padronização de código (PSR / Laravel style)
- `lucascudo/laravel-pt-br-localization` – Traduções PT-BR
- `pestphp/pest` + `pestphp/pest-plugin-laravel` – Testes expressivos
- `soloterm/solo` – UI/UX de terminal (design system CLI)

---

## Stack Front-end / Dev

- `vite` + `laravel-vite-plugin`
- `tailwindcss` v4
- ESLint + Prettier (com plugins Tailwind & organize imports)
- Husky (ganchos Git opcionais após `npm run prepare`)
- Scripts de formatação e lint (`npm run format`, `npm run lint`)

---

## Scripts Úteis

Composer:
- `composer dev` – Sobe servidor, queue listener, logs em streaming (Pail) e Vite simultaneamente (via `concurrently`)
- `composer test` – Executa suite de testes (Pest)
- `composer lint` – Executa Pint
- `composer analyze` – PHPStan/Larastan
- `composer rector` – Executa Rector (interativo)

NPM:
- `npm run dev` – Vite em modo desenvolvimento
- `npm run build` – Build de produção
- `npm run format` / `format:check` – Prettier
- `npm run lint` – ESLint + correções

---

## CI / CD & Automação

GitHub Actions configurados em `.github/workflows/`:
- `tests.yml` – Executa a suíte (Pest) em pull requests
- `lint.yml` – Pint + Prettier (e base para expandir com ESLint / PHPStan)
- `dependabot-auto-merge.yml` – Auto merge para PRs do Dependabot (quando habilitadas)
- `dependabot.yml` – Configurado para atualizações de segurança somente

Você pode ajustar facilmente para rodar build de front-end, deploy ou quality gates adicionais.

---

## Como Usar

Crie um novo projeto a partir deste template:

```bash
laravel new --using=juniorfontenele/laravel-starter minha-app
cd minha-app
php artisan key:generate
```

Ambiente de desenvolvimento completo:
```bash
composer dev
```

Rodar testes:
```bash
composer test
```

---

## Estrutura Visual / Design

Base em Blade. Sinta-se livre para adaptar componentes e extrair partials conforme o projeto cresce.

---

Contribuições são bem-vindas via issues ou pull requests.

---

## Licença

Distribuído sob licença **MIT**.

---

Se este projeto for útil para você, deixe uma ⭐ no repositório!
