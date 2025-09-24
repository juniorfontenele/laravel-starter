# Laravel 12 – Advanced Starter Kit

> Um starter kit moderno e completo para Laravel 12 com multi-tenancy, Filament Admin, Inertia.js + React, e ferramentas avançadas de produtividade e qualidade de código.

---

## Introdução

Este Starter Kit para **Laravel 12** foi pensado para quem quer iniciar um projeto robusto e escalável, já com:

- **Frontend Moderno**: Inertia.js + React 19 + TypeScript + Tailwind v4
- **Admin Panel**: Filament v4 completo com recursos administrativos
- **Multi-tenancy**: Sistema completo de tenants com hosts dedicados
- **Autenticação Social**: Google e Facebook integrados
- **Qualidade de Código**: Pint, PHPStan/Larastan, Rector, ESLint, Prettier
- **Observabilidade**: Logs estruturados, activity tracking, exception monitoring
- **Scripts Avançados**: Desenvolvimento unificado + QA completa
- **CI/CD**: GitHub Actions prontos para produção
- **Localização**: PT-BR incluída

Status: **Work in Progress** – melhorias contínuas, feedback bem-vindo.

---

## Funcionalidades Incluídas

### Core & Infraestrutura
- **Laravel 12** com PHP 8.4
- **Multi-tenancy** completo com models Tenant/TenantHost e middleware dedicado
- **Banco SQLite** pronto por padrão (criado automaticamente no setup)
- **Localização PT-BR** completa
- **Estrutura de testes** robusta (Pest + Playwright para E2E)

### Frontend & UI
- **Inertia.js v2** + **React 19** + **TypeScript**
- **Tailwind CSS v4** com theme system
- **Filament v4** Admin Panel completo
- **Radix UI** components para interface consistente
- **Livewire v3** para componentes reativos específicos

### Autenticação & Permissões
- **Autenticação social** (Google, Facebook) configurada
- **Sistema de permissões** com Spatie Laravel Permission
- **Sessões persistidas** (tabela `sessions`) com relação ao usuário
- **Rate limiting** e proteções de segurança

### Observabilidade & Monitoramento
- **Sentry** integrado + contexto enriquecido (app/version/host/user)
- **Activity Logs** completo com tracking de ações
- **Exception tracking** e centralização de erros
- **Log Viewer** interface para visualização de logs
- **Tracing** simples (Correlation ID / Request ID / X-App-Version)
- **Versionamento automático** com header `X-App-Version` via `VersionService`

### Segurança
- **Headers de segurança** (X-Frame-Options, X-Content-Type-Options, X-XSS-Protection, Referrer-Policy)
- **Middleware** de segurança e contexto para Sentry
- **Regras de senha** fortes em produção
- **HTTPS forçado** fora do ambiente local

### Utilitários & Comandos
- **Comandos Artisan** adicionais (geração de versão, backup de env, evento de inicialização)
- **Helpers** personalizados e traits reutilizáveis
- **Locale dinâmico** do usuário (timezone/locale automático)

---

## Pacotes PHP Instalados

### Produção (Core)
- `laravel/framework` (v12) – Core Laravel 12
- `filament/filament` (v4) – Admin Panel framework completo
- `inertiajs/inertia-laravel` (v2) – Backend Inertia.js
- `laravel/wayfinder` – Roteamento avançado
- `spatie/laravel-permission` (v6) – Sistema de permissões e roles
- `opcodesio/log-viewer` (v3) – Interface para visualização de logs
- `sentry/sentry-laravel` (v4) – Monitoramento e rastreamento de erros

### Desenvolvimento / Qualidade
- `barryvdh/laravel-debugbar` (v3) – Debug de requisições
- `barryvdh/laravel-ide-helper` (v3) – Helpers para autocompletar IDE
- `larastan/larastan` (v3.7.2) – Análise estática (PHPStan para Laravel)
- `rector/rector` (v2) + `driftingly/rector-laravel` – Refactors/upgrades automatizados
- `laravel/pint` – Padronização de código (PSR / Laravel style)
- `laravel/boost` (v1.2) – Ferramentas de desenvolvimento Laravel
- `laradumps/laradumps` (v4.0) – Debug avançado e dump de dados
- `lucascudo/laravel-pt-br-localization` (v3.0) – Traduções PT-BR
- `pestphp/pest` (v4.1.0) + `pestphp/pest-plugin-laravel` – Testes expressivos
- `soloterm/solo` (v0.5.0) – UI/UX de terminal (design system CLI)

### Observabilidade / Utilidades Internas
- **Middlewares avançados**: tracing, segurança, contexto para Sentry, locale do usuário, multi-tenant, terminating
- **VersionService** para geração e injeção de versão (arquivo `VERSION` + config + header)
- **Activity Logging** com models e services dedicados
- **Exception Tracking** centralizado com Filament interface
- **Multi-tenant** architecture com Actions pattern

---

## Stack Front-end / Dev

### Core Frontend
- **React** (v19) + **TypeScript** (v5)
- **Inertia.js React** (v2) – Frontend Inertia.js
- **Vite** (v7) + `laravel-vite-plugin` (v2)
- **Tailwind CSS** (v4)
- **Laravel Wayfinder** – Roteamento avançado

### UI Components & Libraries
- **Radix UI** (Avatar, DropdownMenu, Slot) – Componentes acessíveis
- **Lucide React** – Ícones consistentes
- **React Icons** – Biblioteca complementar de ícones
- **Fontsource Roboto** – Tipografia

### Qualidade & Ferramentas de Desenvolvimento
- **ESLint**
- **Prettier**
- **Husky** 

### Testes E2E
- **Playwright** – Testes end-to-end modernos

### Scripts Disponíveis
- `npm run dev` – Vite em modo desenvolvimento
- `npm run build` – Build de produção
- `npm run format` / `format:check` – Prettier
- `npm run lint` – ESLint + correções automáticas
- `npm run prepare` – Configuração Husky

---

## Observabilidade & Versionamento

- Header de resposta: `X-Correlation-ID`, `X-Request-ID`, `X-App-Version`
- Log context enriquecido (app, container, request, user)
- Integração Sentry com escopos/tag de versão e contexto de requisição
- Serviço de versão gera hash curto (git ou variáveis de build) + data + ambiente

---

## Scripts Úteis

### Composer - Desenvolvimento
- `composer dev` – **Script principal**: Sobe servidor, queue listener, logs em streaming (Pail) e Vite simultaneamente (via `concurrently`)
- `composer test` – Executa suite de testes (Pest)

### Composer - Quality Assurance (QA)
- `composer qa:fix` – **Correção automática**: Executa Pint + Rector
- `composer qa:verify` – **Verificação completa**: Pint + Rector + PHPStan + Debug Check + Testes
- `composer qa:pint:fix` – Executa Laravel Pint (formatação)
- `composer qa:pint:test` – Testa formatação sem aplicar
- `composer qa:pint:bail` – Para na primeira falha de formatação
- `composer qa:rector:dry` – Mostra mudanças do Rector sem aplicar
- `composer qa:rector:apply` – Aplica refatorações do Rector
- `composer qa:stan` – Executa PHPStan/Larastan (análise estática)
- `composer qa:debug:check` – Verifica dumps esquecidos no código
- `composer qa:test:ci` – Executa testes em modo CI

### Comandos Artisan Customizados
- `php artisan app:started` – Emite evento de inicialização (extensível)
- `php artisan system:generate-version` – Gera arquivo VERSION
- `php artisan system:backup-env` – Backup do arquivo .env

### NPM - Frontend
- `npm run dev` – Vite em modo desenvolvimento
- `npm run build` – Build de produção
- `npm run format` / `format:check` – Prettier
- `npm run lint` – ESLint + correções automáticas
- `npm run prepare` – Configuração inicial Husky

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

### Instalação Inicial

Crie um novo projeto a partir deste template:

```bash
laravel new --using=juniorfontenele/laravel-starter minha-app
cd minha-app
```

### Configuração do Ambiente

1. **Configure suas variáveis de ambiente** no arquivo `.env`:
   ```bash
   # Configurações de autenticação social (opcional)
   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret

   # Sentry para monitoramento (opcional)
   SENTRY_LARAVEL_DSN=your_sentry_dsn
   ```

2. **Instale dependências frontend**:
   ```bash
   npm install
   ```

### Desenvolvimento

**Ambiente completo** (recomendado):
```bash
composer dev
```
Este comando inicia: servidor Laravel + queue worker + logs + Vite em paralelo.

**Apenas frontend**:
```bash
npm run dev
```

**Apenas backend**:
```bash
php artisan serve
```

### Testes

```bash
# Testes unitários e feature
composer test

# Verificação completa de qualidade
composer qa:verify

# Testes E2E (Playwright)
npx playwright test
```
---

Contribuições são bem-vindas via issues ou pull requests.

---

## Licença

Distribuído sob licença **MIT**.

---

Se este projeto for útil para você, deixe uma ⭐ no repositório!
