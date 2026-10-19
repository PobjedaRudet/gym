# BegsFit — Authorization Matrix (Phase 1 audit)

All findings are from `config/auth.php`, `app/Http/Kernel.php`, `app/Http/Middleware/*`, `routes/web.php`, `routes/api.php`, controllers and Blade layouts.

## 1. Authentication guards and providers (CONFIRMED, `config/auth.php`)

| Guard | Driver | Provider → Model | Who | Login route |
|---|---|---|---|---|
| `web` (default) | session | `users` → `App\Models\User` | Staff / administrator | `GET/POST /login` (`Auth::routes`, laravel/ui `LoginController`) |
| `member` | session | `members` → `App\Models\Member` | Gym members (portal) | `GET/POST /portal/login` (`MemberAuthController`) |
| `moderator` | session | `moderators` → `App\Models\Moderator` | Moderators/trainers | `GET/POST /moderator/login` (`ModeratorAuthController`) |
| `sanctum` (registered by package) | token/cookie | `config/sanctum.php` `guard => ['web']` | Only `User` has `HasApiTokens` | none — no token issuance |

There is **no `api` guard** and **no token-based login for any role** (CONFIRMED). Password brokers: `users`, `members` (both on `password_resets`).

## 2. Roles as actually implemented

| Role (business name) | Implementation | Evidence | Status |
|---|---|---|---|
| Administrator / staff | Any row in `users` logged in on `web`. No role column. All staff routes only require `auth`. | `routes/web.php:125-173` | CONFIRMED |
| "Super-admin" sub-role | Hard-coded `Auth::user()->email === 'admin@begsfit.ba'` in `AdminPortalObavijestController::authorizeAdminEmail()` and `AdminPortalTerminController::authorizeAdminEmail()` | controllers | CONFIRMED |
| Staff menu variant | Blade only: `Auth::user()->name == 'Admir' \|\| 'admin'` shows a different menu; the other menu shows "Odjavi neaktivne". **Not enforced server-side.** | `resources/views/layouts/report.blade.php:143` | CONFIRMED (UI only) |
| Member | Row in `members` with non-null `password`, logged in on `member`, **and** latest `fees.end >= today` (enforced at login and on every request by `active.member`) | `MemberAuthController::login`, `ActiveMember` | CONFIRMED |
| Moderator | Row in `moderators`, `moderator` guard, `auth.moderator` middleware | `AuthenticateModerator`, `routes/web.php:223-246` | CONFIRMED |
| Member-administrator | `members.is_admin = true`; routes wrapped in `admin.member` middleware; sidebar shows "Admin panel" when `$authMember->is_admin` | `routes/web.php:206-218`, `member/layout.blade.php:558` | CONFIRMED in code — **broken guard check, see §4** |

No third-party authorization package (spatie/permission etc.) — CONFIRMED absent from `composer.json`. Policies `MemberPolicy`, `FeePolicy`, `AttendancePolicy` exist but every method is empty and none is registered in `AuthServiceProvider::$policies`. No Gates defined. FormRequests `Store/Update*Request` return `authorize() false` and are not used by any route. CONFIRMED.

## 3. Middleware (CONFIRMED, `app/Http/Kernel.php`)

| Alias | Class | What it does |
|---|---|---|
| `auth` | `Authenticate` | Default guard (`web`) session check; redirects to `login` |
| `active.member` | `ActiveMember` | Requires `member` guard; looks up latest fee by `end desc`; if `end < today` logs the member out and redirects with "članarina je istekla" |
| `admin.member` | `AdminMember` | `Auth::guard('web')->user()` must exist and have truthy `is_admin`, else 403 |
| `auth.moderator` | `AuthenticateModerator` | Requires `moderator` guard |
| `prevent-back-history` | `PreventBackHistory` | No-cache headers on staff routes |
| `throttle:*` | framework | Applied to member login (10/10 min), register/forgot/reset (5/10 min), contact (5/10 min), `api` group (60/min) |
| `LogRequest` | `LogRequest` | Registered but **not attached** to any route |
| CSRF | `VerifyCsrfToken` | **Excepts `/slanje` and `/slanje2`** |

## 4. Important defects in role enforcement

1. **Member-admin middleware checks the wrong guard.** `AdminMember` reads `Auth::guard('web')->user()` (staff `User`), while member-admin routes sit inside the `active.member` (member guard) group. A member logged in only to the portal gets **403** on all `/portal/obavijesti/kreiraj`, `/portal/termini/kreiraj` etc. The check would only pass if the same browser also had a staff session whose `users` row has `is_admin` — a column that no migration creates. CONFIRMED code; runtime effect INFERRED.
2. **Member-admin writes into moderator FKs.** Even if the guard is fixed, `storeObavijest`/`storeTermin` set `moderator_id` to the member's id (see DATABASE_MAP §2.6).
3. **Strict ownership comparisons.** Moderator/member-admin edit/delete use `$model->moderator_id !== Auth::guard(...)->id()`. Depending on PDO type casting, an int vs string mismatch could deny legitimate owners (INFERRED; not tested).
4. **All staff are equal.** Any `users` account can create/edit/delete members, fees, attendance and see all reports; there is no server-side "receptionist vs owner" distinction (CONFIRMED). Staff accounts cannot be created through the app (register disabled) — creation process UNKNOWN (manual DB/tinker).
5. **Unauthenticated operational routes** (no guard at all): `POST /slanje`, `POST /slanje2`, `POST /api/slanje` (RFID check-in/out), `GET /attendance2` (Ladies-gym kiosk page), `GET /send-mail` (sends a test email). CONFIRMED.
6. **Moderator login has no throttle** (`routes/web.php:225`) and no `ThrottlesLogins` trait. Staff login uses laravel/ui `AuthenticatesUsers` (built-in throttling). CONFIRMED.

## 5. Permission matrix (only what the code supports)

Legend: ✅ allowed (CONFIRMED), ❌ denied (CONFIRMED), ⚠️ intended but broken/conditional, ❓ UNKNOWN, — not applicable.

| Operation | Route(s) | Staff (`web`) | admin@begsfit.ba (`web`) | Member (`member`, active) | Member-admin (`is_admin`) | Moderator | Guest |
|---|---|---|---|---|---|---|---|
| List/search members | `/members`, `/search` | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Create member (+ photo) | `POST /create` | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Edit member / photo | `POST /updateMember` | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Delete member | `DELETE /deleteMember/{member}` | ✅ (fails if FK rows exist — INFERRED) | ✅ | ❌ | ❌ | ❌ | ❌ |
| View member profile + stats | `/memberProfile/{id}` | ✅ any member | ✅ | own only via `/portal/profile`, `/portal/statistics` | own only | ❌ | ❌ |
| Set member goals | `POST /memberProfile/{id}/settings` | ✅ | ✅ | own via `POST /portal/settings` | own | ❌ | ❌ |
| Invalidate member password | `POST /memberProfile/{id}/password/reset` | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Add / edit amount / delete fee | `POST /insertFee`, `POST /updateFee`, `GET /feesDelete/{id}` | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| View fee list | `/fees/{id}` | ✅ | ✅ | only latest `end` shown in own profile | same | ❌ | ❌ |
| RFID check-in/out (main gym kiosk page) | `GET /attendance` + `POST /slanje` | ✅ | ✅ | — | — | — | page ❌, **endpoint ✅** |
| RFID check-in/out (Ladies kiosk) | `GET /attendance2` + `POST /slanje` | ✅ | ✅ | — | — | — | **✅ (no auth)** |
| Attendance list, live, manual checkout, logout all, logout inactive | `/attendance-list`, `/attendance-live`, `POST live`, `/odjava/{id}`, `/odjava-live/{id}`, `POST /logoutAll`, `POST /odjaviNeaktivne` | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| See who is in the gym now | `/portal/live` | ✅ (staff live) | ✅ | ✅ names + photos of all present | ✅ | ❌ | ❌ |
| Reports | `/report`, `/comparison`, `/izvjestaj` | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Read announcements | `/portal/obavijesti` | — | — | ✅ all (not only `javno`) | ✅ | ✅ own only (`/moderator/obavijesti`) | public site shows `javno=true` (3 latest) |
| Create/edit/delete any announcement (incl. `javno`, `promo`) | `/admin/portal-obavijesti*` | ❌ 403 | ✅ | ❌ | ❌ | ❌ | ❌ |
| Create/edit/delete own announcement | `/moderator/obavijesti*` | — | — | ❌ | ⚠️ `/portal/obavijesti*` (403 due to guard bug) | ✅ own only, `tip` without `promo` | ❌ |
| Read training sessions | `/portal/termini` | — | — | ✅ all | ✅ | ✅ own only | public `/begsfit/treninzi.html` weekly schedule |
| Sign up / cancel training | `POST /portal/termini/{t}/prijava`, `/odjava` | — | — | ✅ (capacity + `datum_od` checks) | ✅ | ❌ | ❌ |
| Create/edit/delete any session | `/admin/portal-termini*` | ❌ 403 | ✅ | ❌ | ❌ | ❌ | ❌ |
| Create/edit/delete own session, view sign-ups | `/moderator/termini*`, `/moderator/termini/{t}/prijave` | — | — | ❌ | ⚠️ `/portal/termini*` (403) | ✅ own only | ❌ |
| Upload own profile photo | `POST /portal/profile/photo` | (staff uploads via member edit) | ✅ | ✅ | ✅ | ❌ | ❌ |
| Change own password | `/portal/change-password` | ❌ (no route) | ❌ | ✅ | ✅ | ❌ (no route) | ❌ |
| Activate portal account (emailed password) | `POST /portal/register` | — | — | ✅ if member exists, email matches, no password yet, active fee | — | — | ✅ |
| Forgot / reset password | `/portal/forgot-password`, `/portal/reset-password` | ❌ (staff reset disabled) | ❌ | ✅ | ✅ | ❌ | ✅ |
| Manage staff users | — | ❓ no UI | ❓ | ❌ | ❌ | ❌ | ❌ |
| Manage moderators | — | ❓ no UI (only auto-created rows) | ❓ | ❌ | ❌ | ❌ | ❌ |
| `GET /api/user` | auth:sanctum | ❓ only with a token that nothing issues | ❓ | ❌ | ❌ | ❌ | ❌ |

## 6. Uncertain / undocumented permissions (UNKNOWN)

- How staff and moderator accounts are created and deactivated (no UI, no seeder except `MakeAdminSeeder`, which sets `members.is_admin` for `admin@begsfit.ba` — a *member* row, not a `users` row).
- Whether the gym intends staff sub-roles (receptionist vs owner) — only the name-based menu hints at it.
- Whether the `members.status` checkbox ("Aktiviraj člana") is meant to block access; today it does not.
- Whether a member-admin is supposed to be a member who also has staff powers, or a moderator-like role inside the portal (the code mixes both ideas).
- Whether moderators should see all announcements/sessions or only their own (code: own only).

## 7. Implications for mobile

- Only the `member` role has a coherent, enforceable rule set today (login + active fee + own-data scoping). It is the natural first target for the Flutter app.
- Moderator and member-admin mobile features should wait until the business decides the intended model and the guard/FK defects are fixed.
- A token guard for `Member` must replicate `ActiveMember` on every API request (not only at login), otherwise an expired member keeps API access until token expiry.
