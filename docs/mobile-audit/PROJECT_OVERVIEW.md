# BegsFit — Project Overview (Phase 1 audit)

Audit date: 2026-10-12. Scope: read-only inspection of the local checkout `C:\wamp64\www\begs-gym-new` (git HEAD `048bd571 "Before API implementation"`, clean working tree at the time of inspection).
No code, database, `.env` or dependency was changed. The live MySQL database was **not** connected to; all schema facts come from migrations and code.

Labels used throughout: **CONFIRMED** (seen in code/config), **INFERRED** (reasoned from code, not observed at runtime), **UNKNOWN** (cannot be determined from the repository).

## 1. Confirmed technology stack

| Item | Value | Evidence | Status |
|---|---|---|---|
| Laravel framework | `laravel/framework` constraint `^8.75`, locked **v8.83.27** | `composer.json`, `composer.lock` | CONFIRMED |
| PHP constraint | `^7.3\|^8.0` (composer.json); Composer platform check requires `>= 7.4.0` | `composer.json`, `vendor/composer/platform_check.php` | CONFIRMED |
| PHP actually installed in WAMP / cPanel | not visible from the project folder | — | UNKNOWN |
| Database | MySQL (`DB_CONNECTION=mysql`), raw MySQL functions used in queries (`TIMESTAMPDIFF`, `YEAR()`, `DAYOFWEEK()`, `MODIFY ... ENUM`) | `.env` (key only), `MemberController`, `AttendanceController`, migration `2026_04_29_130000_add_promo_tip_to_obavijesti_table.php` | CONFIRMED |
| Timezone | `Europe/Sarajevo` | `config/app.php` | CONFIRMED |
| Templates | Blade, server-rendered; jQuery + Bootstrap (CDN and compiled) | `resources/views/**`, `resources/views/layouts/*.blade.php` | CONFIRMED |
| Asset build | Laravel Mix 6, Bootstrap 5, Sass; `vue@^3.2.45` installed but `resources/js/app.js` uses Vue 2 syntax (`new Vue`) with only `ExampleComponent` | `package.json`, `webpack.mix.js`, `resources/js/app.js` | CONFIRMED (Vue effectively unused — INFERRED) |
| Sessions / cache / queue | `SESSION_DRIVER=file`, `CACHE_DRIVER=file`, `QUEUE_CONNECTION=sync`, `BROADCAST_DRIVER=log` (local `.env`) | `.env` (non-secret keys only) | CONFIRMED for local; production values UNKNOWN |
| Deployment | cPanel Git deploy: `/bin/cp -R * $DEPLOYPATH` into `public_html`; `vendor/` is committed to git (≈8 366 files) so no Composer run on server | `.cpanel.yml`, `git ls-files vendor` | CONFIRMED |
| Production document root | Project root (not `public/`); `AppServiceProvider` prefixes asset URLs with `/public` in production; root `.htaccess` blocks dotfiles, `app/ config/ vendor/ storage/ ...` | `app/Providers/AppServiceProvider.php`, `.htaccess`, `HITNO-htaccess-zastita.txt` | CONFIRMED (config); behaviour on server INFERRED |

### Relevant Composer packages (locked versions)

| Package | Version | Purpose / relevance | Used in app code? |
|---|---|---|---|
| laravel/sanctum | v2.15.1 | API tokens | Only `HasApiTokens` on `App\Models\User`; `auth:sanctum` on `GET /api/user`. No token is ever issued (`createToken` not found). CONFIRMED |
| laravel/passport | v10.4.1 (+ league/oauth2-server 8.3.6, lcobucci/jwt 4.0.4, firebase/php-jwt 6.3.2) | OAuth2 server | **Not used**: no `Passport::routes()`, no passport guard, no `HasApiTokens` from Passport. CONFIRMED |
| laravel/ui | v3.4.6 | Staff login scaffolding (`Auth::routes`) | Yes |
| intervention/image | 2.7.0 (pinned) | Photo resize/re-encode | Yes (`MemberController`, `MemberPortalController`) |
| fruitcake/laravel-cors | v2.2.0 | CORS for `api/*` | Yes (global middleware) |
| doctrine/dbal | 3.0.0 (pinned) | Column rename migration | Yes (`renameColumn` in `2026_04_20_144113_...`) |
| guzzlehttp/guzzle | 7.5.0 | HTTP client | Yes (Facebook Graph sync) |
| piphp/gpio | 0.4.0 | Raspberry Pi GPIO | Not referenced in `app/`, `routes/`, `resources/` — CONFIRMED unused |
| QR code library | none | — | CONFIRMED absent |
| Push (FCM/OneSignal/APNs) library | none | — | CONFIRMED absent |

## 2. Project structure (relevant parts)

```
app/
  Console/Kernel.php                 scheduler: attendance:auto-logout-long-stays (15 min), facebook:sync-posts (hourly)
  Console/Commands/                  AutoLogoutLongStays, SyncFacebookPosts, TestMailCommand
  Http/Controllers/                  MemberController, FeeController, AttendanceController, HomeController,
                                     MemberAuthController, MemberPortalController,
                                     ModeratorAuthController, ModeratorController,
                                     AdminPortalObavijestController, AdminPortalTerminController,
                                     ContactController, Auth/* (laravel/ui)
  Http/Middleware/                   ActiveMember, AdminMember, AuthenticateModerator, PreventBackHistory, LogRequest (unused)
  Http/Requests/                     Store/Update{Member,Fee,Attendance}Request — empty stubs, authorize() returns false, unused
  Models/                            User, Member, Fee, Attendance, Moderator, Obavijest, TerminTreninga, PrijavaTreninga, Test
  Policies/                          MemberPolicy, FeePolicy, AttendancePolicy — empty stubs, not registered
  Mail/                              MemberPasswordMail, MemberResetPasswordMail, ContactMessageMail, MyTestMail
config/                              auth (3 session guards), sanctum, cors, filesystems, queue, services (facebook)
database/migrations/                 20 migrations (2014 → 2026-09-16)
routes/web.php                       all functional routes
routes/api.php                       3 routes (see API_AUDIT.md)
resources/views/                     staff UI (root), member/ (portal), moderator/, admin/, emails/, public site pages
public/js/main.js, main2.js, live.js RFID kiosk and live-presence front-end (compiled)
public/images/                       member photos + obavijesti images (git-ignored, publicly served)
tests/Feature/MemberRememberMeTest.php the only non-example test
```

## 3. Main modules and where they live

| Module | Main code | Status |
|---|---|---|
| Members (staff CRUD) | `MemberController` (`create`, `updateMember`, `editMember`, `memberProfile`, `search`, `destroy`) | CONFIRMED |
| Membership fees / payments | `FeeController` (`insertFee`, `fees`, `editFee`, `updateFee`, `destroy`) — table `fees` | CONFIRMED |
| RFID attendance | `MemberController::slanje`, kiosk pages `/attendance` and `/attendance2`, `public/js/main.js`/`main2.js` | CONFIRMED |
| Attendance lists / live | `AttendanceController` (`index`, `live`, `live2`, `odjava`, `odjavalive`, `logoutAll`, `odjaviNeaktivne`) | CONFIRMED |
| Reports | `AttendanceController::report`, `::comparison`; `HomeController::izvjestaj` (static view) | CONFIRMED |
| Member portal | `MemberAuthController`, `MemberPortalController`, views `resources/views/member/*` under `/portal` | CONFIRMED |
| Notifications ("obavijesti") | Table `obavijesti`; managed by moderators, admin user, member-admins; Facebook sync | CONFIRMED (in-app announcements, not Laravel notifications) |
| Training schedules ("termini treninga") | Tables `termini_treninga`, `prijave_treninga`; `TerminTreninga::sljedeciTermin()`, `::sedmicniRaspored()` | CONFIRMED |
| Moderators | Separate `moderators` table, `moderator` guard, `/moderator/*` | CONFIRMED |
| Member-administrator | `members.is_admin` + `admin.member` middleware | CONFIRMED in code; **functionally broken — see AUTHORIZATION_MATRIX.md** (INFERRED) |
| Public website | `/begsfit/*` Blade pages, contact form | CONFIRMED |

## 4. Existing frontend architecture

- Fully server-rendered Blade. Four separate UI shells: staff (`layouts.report`, `layouts.app`, `layouts.in`), member portal (`member/layout.blade.php`), moderator (`moderator/layout.blade.php`), public site (`layouts.landing`).
- AJAX is used only by the RFID kiosk (`POST slanje`) and staff live view (`POST live`), both returning hand-built JSON via `echo json_encode(...)` (not `response()->json`).
- No SPA, no Vue usage beyond a stub component, no JSON API consumed by the web UI.
- Staff UI role differences (menu items) are decided in Blade by `Auth::user()->name == 'Admir' || 'admin'` and `email === 'admin@begsfit.ba'` (`resources/views/layouts/report.blade.php:143-147`).

## 5. Automated tests

- PHPUnit 9.5.27, `phpunit.xml` with SQLite lines **commented out** → tests run against the real configured MySQL database (CONFIRMED). Running the test suite writes members/fees into whatever DB `.env` points at (INFERRED from `tests/Feature/MemberRememberMeTest.php`, which creates rows without `RefreshDatabase`).
- `.phpunit.result.cache` records a defect (status 3 = failure) for `MemberRememberMeTest::test_member_login_with_remember_me_sets_recaller_cookie_and_restores_user_without_session` — last recorded run failed (CONFIRMED from cache file; current state UNKNOWN, tests were not run in this audit).
- Factories for Member/Fee/Attendance are empty stubs.

## 6. Technical risks and compatibility concerns

1. **PHP 8.3 vs Laravel 8.83.27** — Laravel 8 officially supported PHP 7.3–8.1 and is end-of-life (security fixes ended January 2023). Running on PHP 8.2/8.3 is possible but unsupported; expect deprecation notices (dynamic properties, `${}` interpolation, etc.) from framework or pinned packages (`doctrine/dbal 3.0.0`, `intervention/image 2.7.0`). INFERRED — the PHP version on WAMP/cPanel was not inspected. Recommendation: confirm `php -v` on both environments and run the app with `E_DEPRECATED` logging before building the API. **No upgrade performed.**
2. **Two API auth packages installed** (Sanctum and Passport). Passport v10 auto-registers its own migrations, so a future `php artisan migrate` would create `oauth_*` tables unless `Passport::ignoreMigrations()` is called. INFERRED from Passport 10 behaviour; a decision is needed before Phase 2.
3. **Schema drift**: code writes/reads `attendances.gym`, but no migration creates that column (`MemberController::slanje`, `AttendanceController::live2`, `MemberPortalController::live`). The live DB must have been altered manually. CONFIRMED discrepancy; live schema UNKNOWN.
4. **`users.is_admin` does not exist in migrations** but `AdminMember` middleware reads it from the `web` guard (staff `User`). See AUTHORIZATION_MATRIX.md.
5. **Foreign-key conflict**: member-admin code writes a *member* id into `obavijesti.moderator_id` / `termini_treninga.moderator_id`, which have FK constraints to `moderators` (migrations `2026_04_20_142033`, `2026_04_20_142040`). CONFIRMED conflict between code and migrations.
6. **Document root = project root on cPanel**; protection relies on `.htaccess` rules. Any mistake in `.htaccess` exposes `.env`/logs. CONFIRMED config, risk INFERRED.
7. **`vendor/` committed to git** — dependency changes for the API (e.g. removing Passport) must be committed as vendor diffs; deploy copies everything with `cp -R *`.
8. **Scheduler** (`attendance:auto-logout-long-stays`, `facebook:sync-posts`) requires a cron entry for `php artisan schedule:run` on cPanel — UNKNOWN whether configured.
9. **No service layer**: business rules (membership activity, attendance toggle, stats) are duplicated inline across controllers and middleware (see BUSINESS_LOGIC.md). A mobile API will need these extracted to avoid divergence.
10. **Tests hit the real DB** (see §5).
