# BegsFit Portal: mobile app plan (Android + iOS)

Goal: the same features as the web member portal (`/portal/*`), as a Flutter app for Android and iOS. The web portal stays exactly as it is.
Based on: `routes/web.php:176-220`, `MemberAuthController`, `MemberPortalController`, `resources/views/member/*`, and the Phase 1 audit in this folder.

## 1. Portal screens → mobile screens → API

| Web portal page (route) | Mobile screen | New API endpoint (`/api/v1/member/...`) | Existing code reused |
|---|---|---|---|
| Login `/portal/login` | Login | `POST login` → token, `POST logout` | `MemberAuthController::login` rules (email + password, password not null, active fee) |
| Activation `/portal/register` | "Aktiviraj nalog" | `POST activate` | `MemberAuthController::register` (emails generated password) |
| Forgot password `/portal/forgot-password` | "Zaboravljena lozinka" | `POST password/forgot` | `MemberAuthController::sendResetLink` (the reset link opens the existing web page) |
| Profile / dashboard `/portal/profile` | Home (Početna): name, photo, membership badge + expiry, totals, this week, 6-month mini chart | `GET me`, `GET dashboard` | `MemberPortalController::profile` queries |
| Photo upload `POST /portal/profile/photo` | Change photo (camera or gallery) | `POST photo` (multipart) | `MemberPortalController::updatePhoto` (same validation, 600×600, ≤1 MB) |
| Statistics `/portal/statistics` | Statistika | `GET statistics` | `MemberPortalController::statistics` |
| Live `/portal/live` | "Ko je u teretani" (Gym / Ladies Gym) | `GET live` | `MemberPortalController::live` |
| Announcements `/portal/obavijesti` | Obavijesti (list + detail, unread badge) | `GET announcements`, `GET badges` | `MemberPortalController::obavijesti`, `last_seen_*` logic from `member/layout.blade.php` |
| Trainings `/portal/termini` | Termini (list, sign up / cancel) | `GET trainings`, `POST trainings/{id}/signup`, `DELETE trainings/{id}/signup` | `MemberPortalController::termini`, `prijaviSe`, `odjaviSe` |
| Rules `/portal/pravila` | Pravila (static text in the app) | none | text from `member/pravila.blade.php` |
| Settings `/portal/settings` | Postavke (monthly goals) | `GET/PUT settings` | `MemberPortalController::updateSettings` validation |
| Change password `/portal/change-password` | Promjena lozinke | `PUT password` | `MemberAuthController::changePassword` |
| Member-admin menu (`admin.member` routes) | **Left out of version 1** | none | Broken on the web today (wrong guard, FK conflict); see AUTHORIZATION_MATRIX.md §4 |

Navigation: bottom tabs Početna · Statistika · Termini · Obavijesti · Više (Live, Pravila, Postavke, Lozinka, Odjava).
Look: dark theme with gold accent like the web portal (`#111111` / `#1a1a1a` background, `#ffb800` / `#c8a84e` accent, light text `#f4f4f5`).

## 2. Backend changes (Laravel), additive only

- **No database schema change.** Tokens use the existing `personal_access_tokens` table (Sanctum migration `2019_12_14_000001`). It must exist in the live DB. That is not confirmed yet, and the first step checks it.
- `App\Models\Member`: add the `Laravel\Sanctum\HasApiTokens` trait. Session login is unaffected.
- New `routes/api.php` group `/api/v1/member` with `auth:sanctum`, plus a new middleware that re-checks the active fee on every request and returns JSON `403 membership_expired` (same rule as `ActiveMember`).
- New controllers under `app/Http/Controllers/Api/V1/Member/` and API Resources that return only safe fields. Never returned: `jmbg`, `code` (RFID), `is_admin`, password fields.
- Shared rules move into small services (`MembershipService`, `MemberStatsService`, `TrainingSignupService`, `ProfilePhotoService`) that the new API calls. Web controllers are **not** switched in this phase, so the web portal does not change.
- Existing `/api/slanje`, `/api/login`, `/api/user` stay untouched in this phase. The security fix for `/slanje` is a separate decision.
- Feature tests for every endpoint on a separate test database (the current `phpunit.xml` points at the real DB, so a test-only DB config is added).
- Sanctum settings: token per device, no expiry by default (decide), throttle on login 10/10 min like the web.

## 3. Flutter app

- Separate project folder next to the Laravel app (suggested `C:\wamp64\www\begsfit-mobile`), so the web app folder only gets backend changes.
- Packages (standard, widely used): `dio` (HTTP), `flutter_secure_storage` (token), `go_router` (navigation), `flutter_riverpod` (state), `image_picker` (camera/gallery), `cached_network_image`, `fl_chart` (charts), `intl` (dates, Bosnian).
- Environments: local (WAMP over LAN IP), production (`https://...begsfit...`).
- Builds and runs need the Flutter SDK, Android Studio and, for iPhone, a Mac with Xcode and an Apple Developer account. These run on your computer, not in this cloud session.

## 4. Order of work

1. Check that `personal_access_tokens` exists locally and on the server. Read-only.
2. Backend API v1 for members, with tests. Diff for review before anything is deployed.
3. Flutter project: login, Home, Statistika, Termini, Obavijesti, Više.
4. Photo upload with camera.
5. Test on an Android device/emulator, then iPhone.
6. Later, separate decisions: push notifications, digital card/QR, member-admin features.

## 5. Not included in version 1

Push notifications, QR card and QR check-in, payments, editing personal data, member-admin and moderator features. Each needs a decision first (see RECOMMENDED_NEXT_STEPS.md, Phase 2 §4).
