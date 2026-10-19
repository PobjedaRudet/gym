# BegsFit — Business Logic (Phase 1 audit)

Every rule below cites the file and method where it lives. There is **no service layer**: logic is in controllers, middleware, model static methods and console commands. Rules that must stay identical between web and mobile are marked **[SHARED RULE]**.

## 1. Members

| Rule | Where | Status |
|---|---|---|
| Created only by staff; photo is **mandatory** on create (redirect with error if missing) | `MemberController::create` | CONFIRMED |
| No server-side validation on create/update (no `$request->validate`, FormRequests unused). Required-ness enforced only by HTML `required` attributes | `MemberController::create`, `::updateMember`; `resources/views/createMember.blade.php` | CONFIRMED |
| `register_date` = now on create; `status` = checkbox value (`'on'` or null on create, `'on'`/`'off'` on update) | same | CONFIRMED |
| `status` has no effect on access, kiosk or portal | grep of `status` usage | CONFIRMED |
| `code` (RFID) is free text, uniqueness not checked | `MemberController::create`, migration | CONFIRMED |
| Delete: `$member->delete()` — FK without cascade on fees/attendances → fails for members with history | `MemberController::destroy` + migrations | INFERRED |
| Staff "reset password" sets `password = NULL` and `remember_token = NULL`. Member must then re-activate via `/portal/register` (forgot-password refuses members with NULL password, despite the flash message mentioning a reset link) | `MemberController::resetMemberPassword`, `MemberAuthController::sendResetLink` | CONFIRMED |
| Goals: visits 1–60, hours 1–300 (stored as minutes); defaults 20 visits / 1800 min | `MemberController::updateProfileSettings`, `MemberPortalController::updateSettings` | CONFIRMED **[SHARED RULE]** |

## 2. Memberships ("članarina") — active status

**Definition used by the portal [SHARED RULE]:** take the member's fee row with the greatest `end` (`orderBy('end','desc')->first()`); the member is active iff `end >= today (start of day)`.
Implemented (duplicated) in:
- `App\Http\Middleware\ActiveMember::handle` (every portal request; logs out expired members)
- `MemberAuthController::login` and `::register`
- `MemberPortalController::profile`, `MemberController::memberProfile` (display)

**Definition used by the RFID kiosk:** `MemberController::slanje` joins `fees` with `fees.end >= today` and orders by `fees.id DESC`; any matching fee row makes the member active. The expiry shown (`rok`) is from the **latest inserted** fee with `end >= today`, not necessarily the greatest `end`. Equivalent for "active yes/no", may differ for the displayed date. CONFIRMED discrepancy (minor).

**Definition used by reports:** "active members" in `AttendanceController::report`/`comparison` = distinct members with a fee whose `start` falls in that month. This is a *different* metric (payments started in month), not membership validity. CONFIRMED.

- `fees.start` is never checked for access: a fee starting in the future still makes a member active today if its `end` is ≥ today. CONFIRMED (no `start <= today` condition anywhere).
- No automatic expiry job, no notification before expiry. CONFIRMED.
- No membership types/plans; one row = one period. CONFIRMED.

## 3. Payments (fees)

| Rule | Where | Status |
|---|---|---|
| Staff enters amount, payment date, start and end (`d-m-Y` input, converted to `Y-m-d`), comment | `FeeController::insertFee` | CONFIRMED |
| No validation (missing/invalid dates throw a Carbon exception → 500) | same | CONFIRMED / INFERRED outcome |
| Edit only changes `amount` | `FeeController::updateFee` | CONFIRMED |
| Delete via GET `/feesDelete/{id}` | `FeeController::destroy` | CONFIRMED |
| No online payment, no payment status, no receipts | whole codebase | CONFIRMED |
| Revenue totals = `SUM(fees.amount)` (all time, and by `start` month) | `AttendanceController::report` | CONFIRMED |

## 4. Attendance

| Rule | Where | Status |
|---|---|---|
| A record is "inside" when `status = 1` and `out IS NULL` | `slanje`, `live2`, `AutoLogoutLongStays` | CONFIRMED |
| Toggle logic: look at the member's **latest** attendance row (by id). `status=1` → check-out; `status=0` or none → new check-in. No date/time check (a forgotten check-in from yesterday is closed by the next scan instead of creating an entry) | `MemberController::slanje` | CONFIRMED **[SHARED RULE]** |
| Only active members (fee `end >= today`) can check in **or out** by scan; expired members inside cannot scan out | same | CONFIRMED |
| Two physical locations: `gym=1` (main, `/attendance`, `main.js`) and `gym=2` (Ladies, `/attendance2`, `main2.js`) | JS + `slanje` | CONFIRMED |
| Auto check-out every 15 min for records with `in <= now − 2h30m` (`out=now`, `status=0`) | `app/Console/Commands/AutoLogoutLongStays.php`, `Console\Kernel::schedule` | CONFIRMED (command description says "3 hours" — mismatch) |
| Manual "odjavi neaktivne": closes records older than **3 h** | `AttendanceController::odjaviNeaktivne` | CONFIRMED (different threshold from the cron) |
| Staff can close one record (`/odjava/{id}`, `/odjava-live/{id}`) or all (`POST /logoutAll`) | `AttendanceController` | CONFIRMED |
| Auto-closed records get `out = now` (not the real exit time), so session-duration statistics include the 2h30m+ | inferred from above | INFERRED |
| Duration statistics = `TIMESTAMPDIFF(MINUTE, in, out)` over closed records; counts include open records | `MemberPortalController::profile/statistics`, `MemberController::memberProfile`, `AttendanceController::comparison` | CONFIRMED **[SHARED RULE]** |

## 5. RFID

- The RFID reader behaves like a keyboard: it types the card code into the focused `#sifra` input and presses Enter; JS posts it to `slanje` (`public/js/main.js`, `main2.js`). CONFIRMED.
- The card identifier is stored directly in `members.code` (one card per member, no history table). CONFIRMED.
- Server validates membership (fees) before writing; it does **not** authenticate the kiosk device. CONFIRMED.
- `AttendanceController::store2` contains a hard-coded fake RFID responder (test codes) — not routed. CONFIRMED dead code.
- `piphp/gpio` is installed but unused (perhaps an earlier turnstile/relay idea) — INFERRED.

### RFID vs. a future mobile QR check-in (business questions)

| Topic | RFID today | Mobile QR (to decide) |
|---|---|---|
| Who scans | Reader at reception scans the member's card | (a) Kiosk/staff scans a QR shown on the phone, or (b) phone scans a QR posted at the door |
| Credential | Static `members.code` | Should be a rotating, signed, short-lived token — never the raw RFID code or member id |
| Device trust | None today | Kiosk/staff device must authenticate; phone must be logged in |
| Toggle in/out | Automatic toggle | Same toggle, or explicit "entry only"? |
| `gym` location | Fixed by kiosk page | Needs a location in the QR or device config |
| Expired members | Rejected, cannot scan out | Same? |

Decisions needed: see MOBILE_GAP_ANALYSIS.md "REQUIRES BUSINESS DECISION" rows.

## 6. Training schedules

| Rule | Where | Status |
|---|---|---|
| A session (`termin`) repeats weekly on ISO weekdays in `dani`, from `datum_od`, between `vrijeme_od` and `vrijeme_do`, with `max_mjesta` (1–100) | `TerminTreninga`, validations in `ModeratorController::storeTermin` etc. | CONFIRMED |
| Create: `datum_od >= today`, `vrijeme_do > vrijeme_od`, at least one day | `storeTermin` (Moderator, Member-admin, AdminPortal) | CONFIRMED |
| Sign-up: allowed only if `datum_od <= today`; not already signed up; current sign-up count < `max_mjesta` | `MemberPortalController::prijaviSe` | CONFIRMED **[SHARED RULE]** |
| Capacity check is count-then-insert (race condition possible; DB unique index prevents only duplicates) | same | INFERRED |
| Sign-up is per session series, not per date; capacity is therefore total subscribers, not per class | migration + code | CONFIRMED |
| Cancel: delete own sign-up, no deadline | `odjaviSe` | CONFIRMED |
| "Next session" and weekly timetable computed in PHP | `TerminTreninga::sljedeciTermin()`, `::sedmicniRaspored()` | CONFIRMED (reusable) |
| Moderators manage only their own sessions; admin@begsfit.ba manages all | `ModeratorController`, `AdminPortalTerminController` | CONFIRMED |

## 7. Notifications

- "Obavijesti" are **in-app announcements** stored in `obavijesti`; members see all of them (`MemberPortalController::obavijesti`, paginated 10). CONFIRMED.
- Unread badges: count of `obavijesti`/`termini_treninga` with `created_at > members.last_seen_*`; opening the page updates the timestamp (`member/layout.blade.php:493-494`, `MemberPortalController::obavijesti`, `::termini`). CONFIRMED **[SHARED RULE]**.
- Types: `info`, `vazno`, `upozorenje`, `promo` (moderators cannot choose `promo` — validation omits it). CONFIRMED.
- `javno = true` shows on the public homepage (latest 3). Set by admin@begsfit.ba or Facebook sync. CONFIRMED.
- Facebook sync (`facebook:sync-posts`, hourly): pulls last 10 page posts via Graph API v19.0, creates public `info` announcements, downloads images. CONFIRMED.
- Laravel Notifications: `User` uses `Notifiable`, but there are no Notification classes, no `notifications` table. CONFIRMED.
- Email: `MemberPasswordMail` (plain generated password), `MemberResetPasswordMail`, `ContactMessageMail`, `MyTestMail`. Sent synchronously (`QUEUE_CONNECTION=sync`, mailables not `ShouldQueue`). CONFIRMED.
- Broadcasting: driver `log`, `BroadcastServiceProvider` commented out. Push (FCM/APNs/OneSignal): none. CONFIRMED.

## 8. Profile photos

| Path | Rules | Status |
|---|---|---|
| Staff upload (`MemberController::create`, `::updateMember`) | No validation rules; requires PHP `fileinfo`; Intervention re-saves to `public/images/{YmdHi}{originalName}` at quality 90 → reduces quality to ≤1 MB, then halves dimensions once | CONFIRMED |
| Member upload (`MemberPortalController::updatePhoto`) | `required|image|mimes:jpg,jpeg,png,webp|max:10240`; EXIF orientation fixed; `fit(600,600)`; saved as `public/images/member_{id}_{time}.jpg`; quality down to 45, then shrink until ≤1 MB; old file is **not** deleted | CONFIRMED **[SHARED RULE]** (the mobile upload should reuse this exact pipeline) |
| Announcement images (moderator, member-admin, admin) | `nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120`; `move()` with `time()_` + **client original file name**, no re-encode | CONFIRMED; security note in API_AUDIT.md §6.10 |
| Storage | Everything under `public/images` (not the `public` disk; `storage/app/public` is empty and `public/storage` link is git-ignored) | CONFIRMED |
| Access control | Files are public static URLs; no authorization on viewing | CONFIRMED |

## 9. Reports

- `AttendanceController::report`: total members, all-time fee sum, members with a fee starting this month / last month and their sums, monthly chart for a selected year. CONFIRMED.
- `AttendanceController::comparison`: per-year/month visits, hours, average minutes, distinct members, "active" by fee start month. CONFIRMED.
- `HomeController::izvjestaj`: static view. CONFIRMED.
- Reports are staff-only and computed live (no stored report tables). CONFIRMED.

## 10. Rules that must stay consistent between web and mobile

1. Active membership = greatest `fees.end >= today` (and re-checked on every request).
2. Portal activation preconditions (member exists by email, no password yet, active fee) and emailed random password.
3. Attendance toggle semantics and active-fee requirement; auto-checkout thresholds.
4. Training sign-up rules (`datum_od`, duplicate, capacity).
5. Photo pipeline (validation, orientation, 600×600, ≤1 MB, naming).
6. Unread counters based on `last_seen_*`.
7. Goal limits and defaults.

Recommendation for Phase 2+: extract these into service classes (e.g. `MembershipService::isActive(Member)`, `AttendanceService::toggle(...)`, `TrainingSignupService`) and make both the web controllers and the API call them, rather than copying queries into API controllers. This is a refactor and must be approved separately.
