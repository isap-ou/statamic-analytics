# AGENTS.md

## Purpose
This repository contains a proprietary Statamic addon that shows GA4 analytics inside the Statamic Control Panel.
When making changes, optimize for reliability, compatibility with Statamic 5 and 6, and predictable CP UX.

## Tech Stack
- Backend: PHP 8.2+, Laravel/Statamic addon
- Analytics provider: `spatie/laravel-analytics:^5`
- Frontend: Vue + Vite + Statamic CP UI components
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
- Run JS lint: `yarn lint` (6.x only)
- Build assets: `yarn build`
- Dev assets: `yarn dev`

## Branch-Specific Rules (5.x vs 6.x)
- Choose branch first and keep changes branch-compatible.
- `5.x` baseline:
  - `statamic/cms:^5.0`, `orchestra/testbench:^9.0`.
  - Frontend: Vue 2.7 + `@vitejs/plugin-vue2` + `chart.js`/`vue-chartjs`.
  - Settings flow uses `src/Controllers/ConfigController.php` + `resources/settings.yaml` + `resources/views/settings.blade.php`.
  - Main analytics page component: `resources/js/components/GoogleAnalytics.vue`.
  - CP routes include `isapp-ga.config.index` and `isapp-ga.config.update`.
- `6.x` baseline:
  - `statamic/cms:^6.0`, `orchestra/testbench:^10.0`.
  - Frontend: Vue 3 + ApexCharts + ESLint/Prettier.
  - Settings flow uses `registerSettingsBlueprint()` in `src/ServiceProvider.php` (no `ConfigController`/`settings.yaml`).
  - Main analytics page component: `resources/js/components/IsappAnalytics.vue`.
  - CP routes are analytics-focused (`isapp-ga.analytics.index`, `isapp-ga.chart`) without separate config controller routes.
- Widget implementation expectations by branch:
  - `5.x`: update `src/Analytics/Analytics.php`, `resources/settings.yaml`, `resources/js/components/GoogleAnalytics.vue` (or related widgets), translations.
  - `6.x`: update `src/Analytics/Analytics.php`, settings blueprint in `src/ServiceProvider.php`, `resources/js/components/IsappAnalytics.vue` + `resources/js/components/widgets/*.vue`, translations.
- Do not backport 6.x-only frontend patterns into 5.x (Vue 3 APIs, ApexCharts, `@statamic/cms/ui` date picker).
- Do not introduce 5.x legacy patterns into 6.x (Vue 2 component API, `vue-chartjs/legacy`, `settings.yaml` config flow).

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
- Run (6.x): `composer test`, `composer lint`, `yarn lint`, `yarn format`, `yarn build`.
- Run (5.x): `composer test`, `composer lint`, `yarn build`.
- Verify no regressions in route names:
  - `isapp-ga.analytics.index`
  - `isapp-ga.chart`
- On `5.x`, also verify config routes:
  - `isapp-ga.config.index`
  - `isapp-ga.config.update`
- Confirm date range and `property_id` handling still validate correctly in controller.
- Confirm UI still works when widget list is empty or partially configured.

## Git Workflow (Commit + PR)
- Do not push unless explicitly requested.
- Before commit, review scope with `git status` and `git diff --stat`.
- Keep commits atomic: one logical change per commit when possible.
- Cross-branch cherry-pick rule:
  - If changes touch any of the files below, create a dedicated commit that contains only cross-branch-safe changes for these files.
  - Target files:
    - `.gitattributes`
    - `AGENTS.md`
    - `src/Analytics/Analytics.php`
    - `src/Controllers/AnalyticsController.php`
    - `src/Widgets/GoogleAnalytics.php`
    - `src/Concerns/HasView.php`
    - `.gitignore`
    - `LICENSE.md`
    - `README.md`
    - `WIDGETS.md`
    - `phpunit.xml`
    - `pint.json`

  - Do not mix these changes with branch-specific frontend/config refactors in the same commit.
- Commit message format:
  - Subject line: `<type>: <short summary>`
  - Empty line after subject.
  - Body: bullet list of concrete changes (`- ...`).
  - Types: `feat`, `fix`, `refactor`, `docs`, `test`, `chore`.
  - Example:
    - `fix: validate GA property id in analytics endpoint`
    - ``
    - `- validate property_id as integer-like value`
    - `- keep existing chart endpoint contract unchanged`
- Prefer imperative subject line, <= 72 chars.
- If behavior changed, include tests or explain gap in PR description.
- Before opening PR, run: `composer test`, `composer lint`, `yarn lint`, `yarn format`, `yarn build`.
- PR description should include:
  - What changed.
  - Why it changed.
  - How it was validated.
  - Any manual QA steps for Statamic CP widgets/pages.
