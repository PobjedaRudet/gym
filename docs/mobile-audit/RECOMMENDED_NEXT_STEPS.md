# BegsFit — Recommended Next Steps

Nothing in this document has been started. Each phase needs explicit approval. Phases are ordered by the priorities given in the Phase 1 brief.

## Phase 2 — Resolve unknowns in the existing system (read-only + decisions)

Goal: remove every UNKNOWN that affects API design. No code changes.

1. **Live schema check (structure only):** `SHOW CREATE TABLE` for `members`, `fees`, `attendances`, `users`, `moderators`, `obavijesti`, `termini_treninga`, `prijave_treninga`, and `SELECT migration FROM migrations` on a copy of production. Confirms `attendances.gym`, `users.is_admin`, FK constraints and indexes.
2. **Environment check:** `php -v` and enabled extensions (fileinfo, gd/imagick) on WAMP and cPanel; whether a cron runs `php artisan schedule:run`; whether queues are possible.
3. **Run the existing test** only against a throw-away database (the current `phpunit.xml` points at the real DB).
4. **Business decisions** (one short meeting, written answers):
   - Who should use the app first: members only, or also moderators/staff?
   - Member-administrator: what exactly may they do, and should they act as moderators?
   - QR check-in: phone shows QR to a scanner, or phone scans a door QR? Both locations (`gym` 1/2)? Same in/out toggle as RFID?
   - Live occupancy: show names/photos or counts only?
   - Should members see payment amounts?
   - Which events send push notifications (new announcement, new session, membership expiring in N days, sign-up confirmation)?
   - Should members be able to edit their own contact data?
5. **Security triage of existing web issues** (decide which to fix before mobile): public `/slanje` PII + attendance writes, `/send-mail`, `/attendance2`, PII in logs, GET-based deletes, moderator login throttling, original file names for announcement images.

Deliverable: `docs/mobile-audit/DECISIONS.md` + updated DATABASE_MAP.md.

## Phase 3 — Confirm mobile authentication

1. Choose **Laravel Sanctum** personal access tokens (already installed, `personal_access_tokens` table exists, works on cPanel without OAuth keys). Leave Passport installed but unused, or remove it in a separate approved change (vendor is committed).
2. Design: add `HasApiTokens` to `Member` (no DB change needed — tokens are polymorphic); member login endpoint applying the same rules as `MemberAuthController::login`; an API middleware equivalent to `ActiveMember` that returns `403 membership_expired` JSON.
3. Token lifetime, device naming, logout/revoke-all, rate limits.
4. Moderator tokens only if Phase 2 decides moderators use the app.

Deliverable: short auth design doc; no DB schema change expected.

## Phase 4 — Design the API contract

1. OpenAPI (YAML) for `/api/v1/...` covering endpoints in API_AUDIT.md §5 that survive Phase 2 decisions.
2. Conventions: JSON envelope, error codes, HTTP status codes, pagination (`page`, `per_page`, `meta`), date/time format (ISO 8601, `Europe/Sarajevo`), image URLs.
3. Explicit field allow-lists (API Resources) — never serialise `jmbg`, `code`, `is_admin`, password fields.
4. Versioning and backward compatibility with the web app (web routes untouched).

## Phase 5 — Reuse existing business logic

1. Extract duplicated rules into services without changing web behaviour:
   `MembershipService` (active status, expiry), `AttendanceService` (toggle, stats), `TrainingSignupService` (sign-up rules, atomic capacity), `ProfilePhotoService` (pipeline from `updatePhoto`), `MemberStatsService` (profile/statistics aggregates).
2. Switch web controllers to the services one at a time, with regression tests (on a test DB) for each.

## Phase 6 — Implement missing backend capabilities

Order: auth → profile/membership → attendance history/stats → announcements → trainings → photo upload → device tokens + FCM push → digital card/QR (after decision) → optional moderator endpoints.
Database changes expected (each to be explained and approved before migration): device tokens table; possibly a QR/card token table or column; possibly a scanner-device table.

## Phase 7 — Create the Flutter application

Member app first: login/activation, profile, membership card, attendance history and stats, announcements, trainings, photo capture/upload, push. Configure environments (local WAMP, staging, production) and secure token storage.

## Phase 8 — Test on Android and iOS

API feature tests (on test DB), Flutter widget/integration tests, real-device testing (camera permissions, push on both platforms incl. APNs via FCM), QR scanning under gym lighting, offline/poor-network behaviour, store compliance (privacy labels for photos and attendance data).

## Suggested immediate Phase 2 starting point

Items 1, 2 and 4 of Phase 2 — they are read-only and unblock everything else.
