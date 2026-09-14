# Begs Gym — Technical Overview

Analysis performed read-only against `C:\wamp64\www\begs-gym-new`. No files were modified.

## 1. Stack & Architecture

- **Framework:** Laravel 8.75 (PHP ^7.3|^8.0), classic MVC + Blade views (no SPA framework, though Vue 3 and vue-loader are present in `package.json` — currently unused/minimal, likely scaffolding for future use).
- **Frontend build:** Laravel Mix 6, Bootstrap 5, jQuery-era Blade templates. 17 top-level Blade views plus `admin/`, `auth/`, `member/`, `moderator/`, `emails/`, `kontakt/`, `layouts/` subfolders.
- **Auth:** Three independent session guards configured in `config/auth.php`:
  - `web` → `App\Models\User` (staff/admin back office, e.g. `/members`, `/attendance-list`, `/report`).
  - `member` → `App\Models\Member` (self-service member portal under `/portal/*`, gated by `active.member` middleware which checks the member has a non-expired fee).
  - `moderator` → `App\Models\Moderator` (a separate content-manager role under `/moderator/*`).
  - An `is_admin` flag on `members` plus an `admin.member` middleware layers a fourth "member who is also admin" role on top of the member guard (used for `/portal/obavijesti` and `/portal/termini` management routes).
- **Other packages:** `laravel/passport` and `laravel/sanctum` are both installed but only Sanctum's `/api/user` route is actually wired up (unused/unauthenticated `POST /api/login` stub always returns `200 OK` without checking credentials). `piphp/gpio` is a dependency but is **not referenced anywhere in `app/`** — RFID hardware integration happens entirely outside this codebase (see §3).
- **Repo hygiene:** the Laravel app shares its repository root with several unrelated static marketing sites (`site/`, `web/`, `webstranica/`, `remote/`, and vhost-named folders `site.begsfit-fight.ba/`, `test.begsfit-fight.ba/`, `web.begsfit-fight.ba/`), plus a `.cpanel.yml` deploy script. These are not part of the Laravel app but live in the same working copy.

## 2. Data Model

Two clearly distinct eras of code coexist:

**Legacy core (2022, no Eloquent relationships — all joins done manually in controllers):**
- `members` — id, name, surname, `code` (RFID identifier, `char`, **no unique constraint**), email, mobile, `jmbg` (national ID, stored as `bigInteger`), register_date, image_path, address fields, `status` (string "on"/"off"), plus later additions: `password`/`remember_token` (member portal login), `is_admin`, `monthly_goal_visits`/`monthly_goal_minutes`, `last_seen_obavijesti`/`last_seen_termini`.
- `fees` — a membership/subscription payment record: date, start, end, amount, comment, `member_id`. A member's "active" status is derived entirely from whether a `fees` row's `end` date is in the future — there is no separate `subscriptions` or `plans` table.
- `attendances` — id, `in`, `out` (nullable timestamp), date, `status` (boolean: 1 = currently checked in), `member_id`. **The live code (`MemberController::slanje`) also writes an `attendances.gym` column that has no corresponding migration** — this is schema drift; a fresh `migrate` on a clean database would not reproduce production's actual schema.
- `Member`, `Fee`, `Attendance` Eloquent models define no relationships (`hasMany`/`belongsTo`) — every join is written by hand with `DB::table`/`Model::join()` in controllers.

**Newer modules (April 2026, properly modeled):**
- `moderators`, `obavijesti` (announcements), `termini_treninga` (training class slots), `prijave_treninga` (member sign-ups for a slot, unique per member+slot) — these models (`Moderator`, `Obavijest`, `TerminTreninga`, `PrijavaTreninga`) do define proper `belongsTo`/`hasMany`/`belongsToMany` relationships and follow more idiomatic Laravel conventions than the legacy core.

Two other tables are unused/dead: `test` (backing an empty `Test` model, referenced by a commented-out debug route) and `password_resets`/`personal_access_tokens`/`failed_jobs` (framework boilerplate).

## 3. RFID Check-in / Check-out Flow

The actual hardware entry point is **`POST /slanje`** (and a second identical route `/slanje2`, presumably a second physical gate/reader), both routed to `MemberController::slanje()`:

1. Both routes are explicitly excluded from CSRF verification (`VerifyCsrfToken::$except`) and carry **no authentication** — they're plain public POST endpoints expecting `{ postObj: { id: <rfid_code>, gym: <location> } }`. This is expected for a headless device integration, but means anyone who can reach the endpoint and guess/replay a member's code can create attendance records.
2. It looks up the member's most recent unexpired `fees` row by `members.code = id AND fees.end >= today`.
   - If none found → member is "inactive" (expired membership), returns `id: 2` and no attendance is written.
   - If found → loads the member, then checks their most recent `attendances` row:
     - No prior row, or prior row has `status = 0` → **check-in**: creates a new `attendances` row (`in = now`, `status = 1`, `gym = <location>`).
     - Prior row has `status = 1` → **check-out**: updates that same row (`out = now`, `status = 0`).
   - The RFID scan is a toggle per member (no distinction between "in" and "out" signal from the hardware — the server infers direction from the member's last state).
3. There is no code in the repo for the reader itself (no GPIO/serial code in `app/`), confirming the RFID reader is a separate device/service that just POSTs JSON here.
4. **Auto-logout safety net:** members who forget to badge out are force-checked-out in two independent places with two different thresholds:
   - `AttendanceController::odjaviNeaktivne()` (manually triggered via `POST /odjaviNeaktivne`, auth-gated) uses a **3-hour** cutoff.
   - `Console/Commands/AutoLogoutLongStays` (scheduled every 15 minutes via the Kernel) uses a **2.5-hour** cutoff, despite its own docblock saying "longer than 3 hours" — the code and its description disagree, and it disagrees with the manual route's threshold too.
5. Live occupancy views: `AttendanceController::live()` (Blade page) and `live2()` (JSON endpoint, also references the undocumented `gym` column) show everyone with `out IS NULL`, ordered by most recent.
6. `MemberController::store2()` is dead code: an unused, unrouted method containing hardcoded test/demo responses (including real-looking hardcoded names and a fake RFID code) — it isn't wired to any route and appears to be leftover scaffolding from early prototyping of this exact endpoint.

## 4. Main Modules (by route group)

- **Back office (`web` guard, `auth` middleware):** member CRUD (`MemberController`), fee/subscription entry (`FeeController`), attendance list & manual check-out (`AttendanceController`), reporting/dashboards (`report`, `comparison` — revenue and attendance trends by month/year), and management screens for announcements/training slots (`AdminPortalObavijestController`, `AdminPortalTerminController`).
- **Member self-service portal (`member` guard, `/portal/*`):** registration/login/password reset, profile + photo upload, settings, personal attendance statistics, live gym occupancy view, announcements ("obavijesti"), and training-class booking ("termini" — sign up/cancel for a class slot). Members flagged `is_admin` get an extra layer of management screens for announcements/classes reachable from the portal itself.
- **Moderator area (`moderator` guard, `/moderator/*`):** a separate staff role focused solely on managing announcements and training-class slots (including viewing who signed up for a slot), independent of the back-office `web` guard.
- **Public/API:** `/`, `/begsfit` (marketing pages), `/slanje` + `/slanje2` (RFID hardware), a stub `/api/login` and `/api/user` (Sanctum), and an unauthenticated `/send-mail` test route left in `routes/web.php`.

## 5. Notable Improvement Areas

1. **RFID `code` has no uniqueness constraint or validation.** Two members could be assigned the same code (nothing in the DB schema or in `MemberController::create`/`updateMember` prevents it), which would make check-in silently resolve to the wrong member. Adding a unique index plus validation is low-risk and high-value.
2. **`jmbg` (national ID) is stored as `bigInteger`.** Bosnian JMBG numbers can start with `0`; storing them numerically silently drops leading digits. This should be a fixed-length string/char column — likely already causing bad data for members whose JMBG starts with 0.
3. **Schema drift:** `attendances.gym` is written by the app but has no migration. A fresh environment (or another developer's local setup) would be missing this column and the RFID endpoint would fail. Worth adding a migration to capture actual production schema, and auditing for other drift.
4. **No real server-side validation.** All `StoreXRequest`/`UpdateXRequest` classes exist but have empty `rules()` and `authorize()` returning `false` — they are not actually used by the routes that create/update data (those use plain `Request` with manual field assignment). There is effectively no validation on member creation, fee entry, dates, amounts, file uploads, etc.
5. **Duplicated/inconsistent auto-logout logic.** Two code paths (manual route + scheduled command) implement the same "forgot to badge out" cleanup with different, undocumented thresholds (3h vs 2.5h). Worth consolidating into one service/method used by both.
6. **RFID endpoint has no shared-secret/IP restriction.** It's necessarily public and CSRF-exempt for the hardware to reach it, but currently has zero authentication — a simple device token or IP allowlist would reduce the risk of forged check-ins.
7. **Dead code and unused dependencies:** `MemberController::store2()` (hardcoded mock data, unrouted), the `test` table/model, `laravel/passport` (installed but unused — Sanctum covers the one API route that exists), and `piphp/gpio` (no GPIO code anywhere) could be removed to reduce surface area and confusion for future maintainers.
8. **Architectural inconsistency between legacy and new modules.** The original core (`Member`/`Fee`/`Attendance`) does everything via manual joins/`DB::table` with no Eloquent relationships, while the April-2026 modules (`Moderator`/`Obavijest`/`TerminTreninga`/`PrijavaTreninga`) use proper relationships and cleaner controllers. Future work on the legacy core could adopt the newer pattern incrementally (adding relationships to `Member`/`Fee`/`Attendance` is backward-compatible and would simplify a lot of the existing controller code).
9. **Image upload handling is duplicated** (near-identical resize/compress-to-under-1MB logic appears in both `MemberController::create` and `MemberController::updateMember`) and lacks MIME/type validation beyond relying on `Intervention\Image` to throw. Extracting a shared helper/service would reduce duplication and centralize validation.
10. **Repo contains unrelated static sites** alongside the Laravel app (`site/`, `web/`, `webstranica/`, vhost folders). Not a code risk, but worth confirming whether these should live in this repository at all, or be split out, to avoid confusion during future deploys.

## 6. What Wasn't Verified

This was a static, read-only code review — the actual production/WAMP database was not queried (the sandboxed shell used for this analysis cannot reach the Windows MySQL instance), so schema-drift claims (e.g. `attendances.gym`) are inferred from code rather than confirmed against the live table structure. A `DESCRIBE attendances;` on the real database would confirm this quickly.
