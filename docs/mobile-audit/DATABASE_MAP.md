# BegsFit — Database Map (Phase 1 audit)

Source of truth for this document: `database/migrations/*.php` and `app/Models/*.php`, cross-checked against queries in controllers.
**The live MySQL database was not inspected.** Where code uses a column that no migration creates, it is flagged as a discrepancy. No real records are included.

Legend: **FK (constraint)** = foreign key declared in a migration (CONFIRMED). **Inferred relation** = only implied by code/joins (INFERRED).

## 1. Tables overview

| Table | Model | Purpose | Created by |
|---|---|---|---|
| `users` | `App\Models\User` | Staff/administrator accounts (`web` guard) | `2014_10_12_000000_create_users_table.php` |
| `password_resets` | — (query builder) | Reset tokens; used by custom member reset flow | `2014_10_12_100000_...` |
| `personal_access_tokens` | Sanctum | API tokens (polymorphic `tokenable`) — table exists, **no tokens issued by code** | `2019_12_14_000001_...` |
| `failed_jobs` | — | Laravel queue failures (queue is `sync`) | `2019_08_19_000000_...` |
| `members` | `App\Models\Member` (extends `Authenticatable`) | Gym members; also member portal login (`member` guard) | `2022_12_08_102312_...` + 5 alter migrations |
| `fees` | `App\Models\Fee` | Membership periods + payment amount ("članarina") | `2022_12_08_102602_...` |
| `attendances` | `App\Models\Attendance` | Entry/exit records (RFID) | `2022_12_08_102641_...` |
| `moderators` | `App\Models\Moderator` (extends `Authenticatable`) | Trainer/moderator accounts (`moderator` guard) | `2026_04_20_142024_...` |
| `obavijesti` | `App\Models\Obavijest` | Announcements / news ("notifications" module) | `2026_04_20_142033_...` + 3 alter migrations |
| `termini_treninga` | `App\Models\TerminTreninga` | Recurring training sessions | `2026_04_20_142040_...` + `2026_04_20_144113_...` |
| `prijave_treninga` | `App\Models\PrijavaTreninga` | Member sign-ups to a training session | `2026_04_20_142047_...` |
| `test` | `App\Models\Test` | Leftover test table (model has no `$table`, so it would map to `tests`, not `test`) | `2022_12_13_134845_...` |

Tables that do **not** exist in migrations (CONFIRMED absent): `roles`, `permissions`, `notifications` (Laravel database notifications), `jobs`, `device_tokens`, `payments` (separate from fees), `oauth_*` (Passport migrations not published, but see PROJECT_OVERVIEW §6.2), `member_cards`/QR tables.

## 2. Table details

### 2.1 `users`
| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `name` | string | Used in Blade to decide menu items (`'Admir'`, `'admin'`) |
| `email` | string, unique | `admin@begsfit.ba` gets extra portal-admin rights (hard-coded) |
| `email_verified_at` | timestamp null | Not used (verification routes disabled) |
| `password` | string | bcrypt hash — **sensitive** |
| `remember_token` | string null | **sensitive** |
| timestamps | | |

- No role column. **`is_admin` is read from this guard by `AdminMember` middleware but no migration adds it** (discrepancy; live column UNKNOWN).
- Controllers: `Auth\LoginController`, every staff route (`auth` middleware).

### 2.2 `members`
| Column | Type (migration) | Notes / sensitivity |
|---|---|---|
| `id` | bigint PK | |
| `name`, `surname` | string | Personal data |
| `code` | `char` (default length) **not unique, not indexed** | **RFID card identifier** used by `MemberController::slanje` (`where('members.code', $id)`). Sensitive (acts as an access credential). |
| `email` | string **nullable, not unique** | Member portal login identifier. Lookups use `->first()`; duplicates would be ambiguous. |
| `password` | string nullable (added `2026_04_20_124327`) | bcrypt hash; `NULL` = portal account not activated. **Sensitive** |
| `remember_token` | string null (added same migration) | **Sensitive** |
| `mobile` | string | Personal data |
| `jmbg` | bigInteger | **National ID number — highly sensitive** (stored as integer: leading zeros would be lost — INFERRED) |
| `register_date` | date | Set to `now()` on create |
| `image_path` | string (not nullable) | File name inside `public/images/` |
| `street`, `post_no`, `city` | string | Address — personal data |
| `status` | string | Staff checkbox `'on'`/`'off'`; **not used in any access decision** (CONFIRMED by grep) |
| `is_admin` | boolean default false (added `2026_04_27_...`) | Member-administrator flag |
| `monthly_goal_visits` | unsigned smallint default 20 | Portal goals |
| `monthly_goal_minutes` | unsigned smallint default 1800 | Portal goals |
| `last_seen_obavijesti` | timestamp null | Unread-announcement badge |
| `last_seen_termini` | timestamp null | "New sessions" badge |
| timestamps | | |

- Model: `$fillable` includes `password`, `is_admin`, `code`, `jmbg`; `$hidden` = `password`, `remember_token` only (so `jmbg`, `email`, `mobile`, address **are serialised** when a Member is returned as JSON — see API_AUDIT.md).
- Model has **no Eloquent relationships** defined (no `fees()`, `attendances()`), and no `HasApiTokens`.
- Controllers: `MemberController`, `FeeController`, `AttendanceController`, `MemberAuthController`, `MemberPortalController`, `ModeratorController` (count), middleware `ActiveMember`.

### 2.3 `fees`
| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `date` | date | Payment date (entered by staff) |
| `start` | date | Membership period start |
| `end` | date | Membership period end — **drives "active member" everywhere** |
| `amount` | decimal(8,2) | Amount paid |
| `comment` | string (not nullable) | |
| `member_id` | unsigned bigint | **FK (constraint) → `members.id`**, no `ON DELETE` clause |
| timestamps | | |

- There is no payment status, method, currency, or invoice number. A "payment" and a "subscription period" are the same row. CONFIRMED.
- Model: no relationships defined. Controllers: `FeeController`, `AttendanceController::report/comparison`, `MemberController::slanje/memberProfile`, `MemberAuthController`, `MemberPortalController::profile`, `ActiveMember`.

### 2.4 `attendances`
| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `in` | timestamp | Entry time (reserved word — always back-ticked in raw SQL) |
| `out` | timestamp null | Exit time; `NULL` = currently inside |
| `date` | date | Day of entry |
| `status` | boolean | `1` = inside, `0` = left |
| `member_id` | unsigned bigint | **FK (constraint) → `members.id`**, no `ON DELETE` |
| `gym` | **not in any migration** | Code writes `1` (main gym kiosk) or `2` (Ladies gym kiosk) and filters on it. **Discrepancy: column must exist in live DB, type UNKNOWN.** Not in `Attendance::$fillable` (set via property assignment). |
| timestamps | | |

- Controllers: `MemberController::slanje`, `AttendanceController`, `MemberPortalController`, `AutoLogoutLongStays` command.

### 2.5 `moderators`
`id` PK, `name`, `email` unique, `password` (sensitive), `remember_token`, timestamps.
Relationships (model): `hasMany(Obavijest)`, `hasMany(TerminTreninga)`.
A system row `facebook-sync@begsfit.ba` is inserted by migration `2026_09_16_134909_...` (random password). `AdminPortal*Controller::resolveModeratorForCurrentAdmin()` auto-creates a moderator row mirroring the staff admin's email.

### 2.6 `obavijesti`
| Column | Type | Notes |
|---|---|---|
| `id` | PK | |
| `moderator_id` | foreignId | **FK (constraint) → `moderators.id` ON DELETE CASCADE** |
| `fb_post_id` | string null unique | Facebook post id (sync) |
| `naslov` | string | Title |
| `sadrzaj` | text | Body |
| `slika` | string null | File name in `public/images/obavijesti/` |
| `tip` | ENUM `info, vazno, upozorenje, promo` default `info` | `promo` added by raw `ALTER` |
| `javno` | boolean default false | Shown on public website when true |
| timestamps | | `created_at` overwritten by FB sync via `forceFill` |

- Model relation: `belongsTo(Moderator)`.
- **Discrepancy:** `MemberPortalController::storeObavijest` writes `Auth::guard('member')->id()` (a *member* id) into `moderator_id`. With the FK in place, this either fails (no moderator with that id) or silently attributes the post to an unrelated moderator with the same numeric id. CONFIRMED conflict in code; runtime outcome INFERRED.

### 2.7 `termini_treninga`
| Column | Type | Notes |
|---|---|---|
| `id` | PK | |
| `moderator_id` | foreignId | **FK (constraint) → `moderators.id` ON DELETE CASCADE** (same member-id discrepancy as above via `MemberPortalController::storeTermin`) |
| `naziv` | string | Name |
| `opis` | text null | Description |
| `datum_od` | date | Renamed from `datum`; first date the recurring session is valid |
| `dani` | json | ISO weekdays `1..7` (cast `array`) |
| `vrijeme_od`, `vrijeme_do` | time | Start/end time |
| `max_mjesta` | unsigned int default 20 | Capacity |
| timestamps | | |

- Relations: `belongsTo(Moderator)`, `hasMany(PrijavaTreninga, 'termin_id')`, `belongsToMany(Member, 'prijave_treninga')`.
- No end date and no per-occurrence table: a session repeats weekly forever from `datum_od`. CONFIRMED.

### 2.8 `prijave_treninga`
`id`, `termin_id` (**FK → termini_treninga ON DELETE CASCADE**), `member_id` (**FK → members ON DELETE CASCADE**), timestamps, **unique(`termin_id`,`member_id`)**.
A sign-up applies to the whole recurring session, not to a specific date. CONFIRMED.

### 2.9 `password_resets`
`email` (index), `token` (hashed by app code), `created_at`. Shared by the staff broker config and the custom member flow (`MemberAuthController`). Members and staff with the same email would overwrite each other's row (INFERRED; staff reset routes are disabled, so low impact today).

## 3. Relationship summary

| From | To | Kind | Status |
|---|---|---|---|
| fees.member_id | members.id | FK constraint | CONFIRMED |
| attendances.member_id | members.id | FK constraint | CONFIRMED |
| obavijesti.moderator_id | moderators.id | FK constraint, cascade | CONFIRMED |
| termini_treninga.moderator_id | moderators.id | FK constraint, cascade | CONFIRMED |
| prijave_treninga.termin_id / member_id | termini_treninga.id / members.id | FK constraint, cascade | CONFIRMED |
| Member → Fee / Attendance | Eloquent | **not defined**; joins written by hand in controllers | CONFIRMED absent |
| Member "active" ↔ latest `fees.end` | business relation | computed per request | CONFIRMED (see BUSINESS_LOGIC.md) |
| members.code ↔ physical RFID card | business relation | lookup by string equality | CONFIRMED |
| users ↔ moderators (admin@begsfit.ba) | by matching email | `firstOrCreate` in AdminPortal controllers | CONFIRMED |
| users ↔ members | none | — | CONFIRMED absent |

Consequence (INFERRED): `MemberController::destroy` (`$member->delete()`) will fail with a FK error for any member who has fees or attendances, because those FKs have no cascade.

## 4. Sensitive data inventory

| Data | Location | Exposure notes |
|---|---|---|
| Password hashes | `users.password`, `members.password`, `moderators.password` | Hidden from serialisation via `$hidden` |
| Remember tokens | same tables | Hidden |
| National ID (JMBG) | `members.jmbg` | **Not hidden**; returned by `/slanje` JSON (see API_AUDIT.md); logged via `Log::info($request)` in `MemberController::create` |
| Contact data (email, mobile, address) | `members` | Not hidden; same exposure as JMBG |
| RFID code | `members.code` | Not hidden; equals the access credential |
| Photos | files in `public/images/` (`member_{id}_{timestamp}.jpg` for portal uploads) | Publicly reachable URLs, predictable names |
| Attendance history | `attendances` | Member portal `live` page shows every present member's name + photo to all active members |
| Facebook page token | `.env` only | Not in DB (value not read in this audit) |

## 5. Missing / unconfirmed schema information

1. Live type and default of `attendances.gym` — UNKNOWN (no migration).
2. Whether `users.is_admin` exists in the live DB — UNKNOWN.
3. Whether the live DB actually has the FK constraints on `obavijesti`/`termini_treninga` (member-admin writes would violate them) — UNKNOWN.
4. Whether `migrations` table on production matches the 20 files (e.g. `2026_04_27_add_is_admin_to_members_table.php` has a non-standard name without time part) — UNKNOWN.
5. Indexes beyond PK/unique/FK (e.g. on `members.code`, `members.email`, `attendances.in`) — none in migrations; live UNKNOWN.
6. Character length of `members.code` (`char()` with default length) — depends on `Schema::defaultStringLength(191)` at migration time; UNKNOWN in live DB.

**Recommended (read-only) follow-up:** run `SHOW CREATE TABLE` for `members`, `fees`, `attendances`, `users`, `obavijesti`, `termini_treninga` on a *copy* of the database and attach the output (structure only, no rows) before Phase 2.
