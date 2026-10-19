# BegsFit — Mobile Gap Analysis (Phase 1 audit)

Status values: **IMPLEMENTED** (usable by a mobile client today), **PARTIALLY IMPLEMENTED** (logic exists for web but no API, or incomplete), **MISSING**, **UNKNOWN**, **REQUIRES BUSINESS DECISION**.

Because there is no usable API (API_AUDIT.md), no feature is IMPLEMENTED *for mobile*. "Partially implemented" means the backend logic exists in the web app and can be reused.

| # | Feature | Status | Existing implementation | Reusable backend components | Missing API functionality | Security considerations | Depends on |
|---|---|---|---|---|---|---|---|
| 1 | Member authentication (login/logout) | PARTIALLY IMPLEMENTED | Session login `MemberAuthController::login` (email + password + active fee), remember-me | `member` provider, `Member` model, login rules | Token issuance/revocation (Sanctum on `Member`), JSON errors, device name | Re-check active fee on every request; throttle; token expiry; do not reuse `/api/login` placeholder | Decision Sanctum vs Passport (#16) |
| 2 | Account activation & password reset | PARTIALLY IMPLEMENTED | `MemberAuthController::register` (emails generated password), `sendResetLink`, `resetPassword`, `changePassword` | Same methods' rules, mailables | JSON endpoints; deep link or web fallback for reset link | Enumeration messages; plain password in email | #1 |
| 3 | Role-based access control | PARTIALLY IMPLEMENTED | 3 session guards; member scoping by `Auth::guard('member')`; moderator ownership checks | Guard/provider config | Token abilities or role claims for member / moderator / member-admin | Member-admin guard bug, FK conflict, hard-coded admin email | #4, #17 |
| 4 | Member-administrator features in app | REQUIRES BUSINESS DECISION | Routes exist but `AdminMember` checks `web` guard → 403 | Validation rules in `MemberPortalController` admin methods | Everything | Must fix guard and `moderator_id` FK model first | Business definition of role |
| 5 | Member profile (view) | PARTIALLY IMPLEMENTED | `MemberPortalController::profile` (Blade) | Queries for totals, week, 6-month chart | `GET me` JSON + resource that hides `jmbg`, `code`, `is_admin` | PII minimisation | #1 |
| 6 | Edit profile data (name, phone, address) | MISSING | Only staff can edit (`updateMember`); member can edit goals and photo only | — | Endpoints if allowed | — | Business decision whether members may edit |
| 7 | Membership status & expiry | PARTIALLY IMPLEMENTED | `ActiveMember`, profile `istekClanarine`/`aktivanClan` | Active rule (latest `fees.end`) | `GET membership` | — | #1 |
| 8 | Subscription / payment history | PARTIALLY IMPLEMENTED | Staff-only `FeeController::fees`; member sees only expiry | `fees` table | Member-scoped list endpoint | Show amounts? (business) | #1 |
| 9 | Online payment / renewal | MISSING | None | — | Payment provider integration | PCI, app-store rules | REQUIRES BUSINESS DECISION |
| 10 | Attendance history | PARTIALLY IMPLEMENTED | Aggregates in `profile`/`statistics`; no member-facing list of individual visits | `attendances` queries | Paginated history endpoint + stats endpoint | Own data only | #1 |
| 11 | Statistics & goals | PARTIALLY IMPLEMENTED | `MemberPortalController::statistics`, `updateSettings` | Same queries/validation | JSON endpoints | — | #1 |
| 12 | Digital membership card (QR) | MISSING | No QR library, no card view, no token field | Member identity + active rule | Card endpoint, QR token generation/verification | Must not encode `members.code` (RFID) or JMBG; rotating signed token | #13 |
| 13 | QR check-in at gym | REQUIRES BUSINESS DECISION | RFID toggle in `MemberController::slanje` | Toggle + active rule (after extraction to a service) | Scanner endpoint (authenticated kiosk/staff) or member-scan endpoint | Replay, screenshot sharing, device trust, `gym` location | Decisions in BUSINESS_LOGIC.md §5 |
| 14 | Live gym occupancy | PARTIALLY IMPLEMENTED | `MemberPortalController::live` (names + photos of everyone inside) | Query | JSON endpoint | REQUIRES BUSINESS DECISION: show names/photos or only counts | #1 |
| 15 | Push notifications | MISSING | In-app announcements only; no device tokens, no FCM, queue `sync`, no notification classes | `obavijesti` data, `last_seen_obavijesti` | Device-token table + endpoint, FCM sender, trigger points (new announcement, new session, membership expiring) | FCM server credentials in `.env`; opt-in | Queue/cron on cPanel (UNKNOWN) |
| 16 | API auth package choice | REQUIRES BUSINESS DECISION (technical) | Sanctum v2.15.1 and Passport v10.4.1 both installed; only Sanctum referenced | `personal_access_tokens` migration exists | — | Passport would auto-add `oauth_*` migrations | — |
| 17 | Announcements feed | PARTIALLY IMPLEMENTED | `MemberPortalController::obavijesti` (paginated 10, all types) | `Obavijest` model | List/detail endpoints, unread count, image URLs | — | #1 |
| 18 | Training schedule (view) | PARTIALLY IMPLEMENTED | `MemberPortalController::termini`, `TerminTreninga::sedmicniRaspored()` / `sljedeciTermin()` | Model methods | JSON endpoints with `is_signed_up`, free places | — | #1 |
| 19 | Training sign-up / cancel | PARTIALLY IMPLEMENTED | `prijaviSe`, `odjaviSe` | Rules | Endpoints with proper status codes | Atomic capacity check | #18 |
| 20 | Profile photo via camera | PARTIALLY IMPLEMENTED | `MemberPortalController::updatePhoto` (validated, re-encoded) | Whole pipeline | Multipart API endpoint; return photo URL | Photos are public static files with predictable names | #1 |
| 21 | Moderator mobile features | REQUIRES BUSINESS DECISION | `ModeratorController` (own announcements/sessions, sign-up list) | Validation rules | Token auth for `Moderator`, endpoints | No login throttling today | #3 |
| 22 | Staff/admin mobile features (members, fees, kiosk) | UNKNOWN | Full web module | — | Out of initial member-app scope? | High-privilege; all staff equal today | Business scope |
| 23 | Gym rules page | PARTIALLY IMPLEMENTED | Static Blade `member/pravila.blade.php` | Text | Content endpoint or bundle in app | — | — |
| 24 | Localization (Bosnian) | PARTIALLY IMPLEMENTED | Messages hard-coded in Bosnian in controllers; `config/app.php` locale `en` | — | Consistent error codes + messages | — | — |

## Key blockers before any mobile work

1. Close the public PII/attendance endpoint (`/slanje`, `/api/slanje`) or at least confirm it is acceptable — the mobile API must not inherit it.
2. Decide Sanctum vs Passport (recommendation: Sanctum, already partly wired, simpler on cPanel).
3. Confirm the live DB schema (`attendances.gym`, `users.is_admin`, FKs) with structure-only dumps.
4. Decide the member-admin and moderator role model before exposing them in the app.
5. Decide QR check-in workflow (BUSINESS_LOGIC.md §5).
6. Confirm PHP version and cron availability on cPanel (affects push notifications and auto-checkout).
