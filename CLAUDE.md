# CLAUDE.md

Guidance for Claude Code and other AI agents working in this repository.

## Project overview

This is the official Laravel SDK for the Moneroo payment API, targeting African mobile-money and card payments. It is a Composer package (`moneroo/moneroo-laravel`) that wraps the Moneroo REST API (`https://api.moneroo.io/v1`) and is consumed by Laravel applications that need to initialize/verify payments and payouts. Requires PHP 8.1+ and Laravel 9–13.

## Tech stack

- PHP ^8.1
- Laravel (illuminate/contracts) ^9.0 || ^10.0 || ^11.0 || ^12.0 || ^13.0
- GuzzleHTTP ^7.7 (underlying HTTP transport via Laravel's Http facade)
- PHPUnit ^9.6 / ^10.5 / ^11.0 (test runner via Orchestra Testbench)
- Larastan ^2.9 / ^3.0 (PHPStan level 4 static analysis)
- axazara/php-cs (php-cs-fixer ruleset for code style)

## Getting started

```bash
composer install

# In a host Laravel app — install config and env stubs:
php artisan moneroo:install
```

Set credentials in `.env`:

```
MONEROO_SECRET_KEY=your-secret-key
```

To point the SDK at a local/staging API, set `moneroo.devMode = true` and `moneroo.devBaseUrl` in `config/moneroo.php`.

## Common commands

| Task | Command |
|---|---|
| Test | `composer test` |
| Lint (dry-run) | `composer sniff` |
| Format | `composer format` |
| Static analysis | `composer analyse` |

## Architecture

All source lives under `src/`:

- `Moneroo.php` — base class; reads config, validates credentials, provides `validateData()` using Laravel's Validator.
- `Payment.php` / `Payout.php` — final classes extending `Moneroo`; expose `init()`, `verify()`, `get()`, and (Payment-only) `markAsProcessed()`.
- `Traits/Request.php` — `sendRequest()` trait using Laravel's `Http` facade; maps HTTP status codes to typed exceptions.
- `Facades/PaymentFacade.php` / `PayoutFacade.php` — Laravel facade aliases `MonerooPayment` and `MonerooPayout`.
- `Providers/MonerooServiceProvider.php` — auto-discovered service provider; registers bindings and publishes config.
- `Console/InstallCommand.php` — `php artisan moneroo:install` command.
- `Exceptions/` — typed exceptions per HTTP status (401, 403, 404, 400/422, 406, 503, etc.).
- `Config.php` — package constants (`VERSION`, `BASE_URL`, `TIMEOUT`).

Tests live in `tests/` and use Orchestra Testbench; PHPUnit is configured in `phpunit.xml.dist` with randomised execution order.

## Conventions

- Code style is enforced by `axazara/php-cs` (php-cs-fixer); run `composer format` before every commit and `composer sniff` in CI.
- Static analysis runs PHPStan at level 4 via Larastan; run `composer analyse` before pushing.
- Every change must include new test cases, a CHANGELOG entry, and a version bump in `Config::VERSION`.
- The `unused-scanner.php` script at the root can be used to detect unused dependencies (the README calls this `composer unused`, but no such script exists in `composer.json`; run the file directly if needed).
- Follow KISS: keep classes focused on a single resource (Payment vs. Payout); do not add shared state or side effects to request handling.

## Git Conventions

### 1. Branch names

Enforced regex (`branch_name_pattern`):
```
^(feature|fix|hotfix|chore|docs|refactor|test|ci|perf|build|style)/[a-z0-9._-]+$
```

- Lowercase only, kebab-case after the prefix, **max 50 characters** total.
- Use the full word `feature/` — **never** `feat/` (the short `feat` form is only for commit message types).
- Include the ticket id when relevant: `feature/AXA-123-add-stripe` (the ticket id is lowercased to satisfy the pattern — e.g. `feature/axa-123-add-stripe`).
- **Never** use a `claude/` prefix or any prefix outside the allowed set.
- `main`, `release`, `staging` are permanent protected branches — never push to them directly.
- If a branch is misnamed, rename it before pushing: `git branch -m <old> <new>`.

### 2. Commit messages
Enforced regex (`commit_message_pattern`), applied to **every** commit:
```
^(feat|fix|docs|style|refactor|perf|test|build|ci|chore|revert)(\([^)]+\))?!?: .+
```
- Lowercase type, optional scope in parens, optional `!` for breaking changes, subject after `: `.
- Subject starts with a lowercase letter and has no trailing period.
- Examples: `feat(checkout): add Apple Pay support`, `fix(api): handle expired tokens`, `chore(deps): bump axios from 1.7.2 to 1.15.2`, `refactor!: drop Node 18 support`.
- Do not rewrite Dependabot commits — `chore(deps): bump X from a to b` is already enforced via `.github/dependabot.yml`.

### 3. Files that are always rejected
Never stage or commit:
- `.env`, `.env.*` (only `.env.example` and `.env.sample` are allowed), `**/.env`, `**/.env.*`
- Private keys: `**/id_rsa{,.pub}`, `**/id_dsa`, `**/id_ecdsa`, `**/id_ed25519`, `**/.ssh/id_*`
- Credentials: `**/.aws/credentials`, `**/credentials.json`, `**/service-account.json`, `**/firebase-adminsdk-*.json`, `**/secrets.{yml,yaml}`
- Extensions: `*.pem`, `*.key`, `*.p12`, `*.pfx`, `*.jks`, `*.keystore`, `*.ppk`, `*.asc`, `*.gpg`
- Any file larger than 100 MB (use git LFS)
If a secret is needed, use `.env.example` for env vars and an external secret manager for credentials.

### Pull requests targeting `main`, `release`, `staging`
All three are protected — a PR is required (direct push blocked):
- 1 approval, all conversations resolved, **squash or rebase merge only** (linear history enforced — no merge commits).
- Commits must be GPG- or SSH-signed. Signing is required for `main` (`required-signatures-main` ruleset).
- The PR **title** becomes the squash commit message and must match the commit-message regex above (enforced on all three branches).

**Required workflows run on PRs whose base is `main` only** (not `release`/`staging`): `Branch naming convention`, `PR title — Conventional Commits`, and `PR size labeler`.
If a check shows `Waiting for workflow to run` for over a minute, the third-party action is likely missing from the enterprise allowlist.

When the branch-naming or PR-title check fails, the baseline bot auto-posts rename/title suggestions, following the enforced regex patterns.
If the bot's suggestions are incorrect, edit the PR title or branch name to match the required format.

### Pre-push checklist
Before running `git push`:
1. Branch name matches the regex.
2. Every commit in `origin/main..HEAD` matches the commit pattern (`git log --format=%s origin/main..HEAD`).
3. No staged file is in the blocked paths/extensions list.
4. Commits are signed if the target is `main`.

If any check fails, fix it locally rather than letting the server reject the push.
