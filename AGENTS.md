# AGENTS.md

## Purpose
This repository contains a proprietary Statamic addon that shows GA4 analytics inside the Statamic Control Panel.
When making changes, optimize for reliability, compatibility with Statamic 6, and predictable CP UX.

## Tech Stack
- Backend: PHP 8.2+, Laravel/Statamic addon (`statamic/cms:^6.0`)
- Analytics provider: `spatie/laravel-analytics:^5`
- Frontend: Vue 3 + Vite + Statamic CP UI components
- Styling/tooling: Tailwind CSS, ESLint, Prettier, Laravel Pint

## Project Layout
- `src/ServiceProvider.php`: addon bootstrapping, settings blueprint, CP routes, navigation
- `src/Controllers/AnalyticsController.php`: CP page + JSON endpoint (`isapp-analytics/{chart?}`)
- `src/Analytics/Analytics.php`: custom analytics fetch methods (extends Spatie analytics service)
- `src/Widgets/GoogleAnalytics.php`: dashboard widget integration
- `resources/js/components/IsappAnalytics.vue`: main CP analytics view, dynamic widget loading
- `resources/js/components/widgets/*.vue`: individual analytics widgets
- `resources/views/*.blade.php`: CP blade views
- `resources/lang/en/cp.php`: UI translations

## Local Commands
- Install PHP deps: `composer install`
- Install JS deps: `yarn install`
- Run tests: `composer test`
- Run PHP lint/style: `composer lint`
- Run JS lint: `yarn lint`
- Build assets: `yarn build`
- Dev assets: `yarn dev`

## Implementation Rules
- Preserve license/copyright headers in source files.
- Keep `declare(strict_types=1);` in PHP files.
- Follow existing namespace root: `Isapp\\GoogleAnalytics\\`.
- Do not commit secrets or credentials JSON paths/contents.
- Keep API method naming contract:
  - Frontend calls `/{chart}`.
  - Backend resolves to `fetch{chart}` in `src/Analytics/Analytics.php`.
- For new widgets, update both backend and frontend:
  - Add/extend fetch method in `src/Analytics/Analytics.php`.
  - Add widget option in settings blueprint (`src/ServiceProvider.php`).
  - Add Vue widget component in `resources/js/components/widgets/`.
  - Ensure widget is rendered by `IsappAnalytics.vue` dynamic loading pattern.
  - Add/adjust translation strings in `resources/lang/en/cp.php`.

## Quality Checklist Before Finishing
- Run: `composer test`, `composer lint`, `yarn lint`, `yarn format`, `yarn build`.
- Verify no regressions in route names:
  - `isapp-ga.analytics.index`
  - `isapp-ga.chart`
- Confirm date range and `property_id` handling still validate correctly in controller.
- Confirm UI still works when widget list is empty or partially configured.

## Git Workflow (Commit + PR)
- Do not push unless explicitly requested.
- Before commit, review scope with `git status` and `git diff --stat`.
- Keep commits atomic: one logical change per commit when possible.
- Commit message format:
  - `<type>: <short summary>`
  - Types: `feat`, `fix`, `refactor`, `docs`, `test`, `chore`.
  - Example: `fix: validate GA property id in analytics endpoint`.
- Prefer imperative subject line, <= 72 chars.
- If behavior changed, include tests or explain gap in PR description.
- Before opening PR, run: `composer test`, `composer lint`, `yarn lint`, `yarn format`, `yarn build`.
- PR description should include:
  - What changed.
  - Why it changed.
  - How it was validated.
  - Any manual QA steps for Statamic CP widgets/pages.
