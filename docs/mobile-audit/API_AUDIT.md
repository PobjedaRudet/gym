# BegsFit — API Audit (Phase 1 audit)

## 1. Summary

The application has **no usable mobile API**. `routes/api.php` contains three routes: one is the RFID kiosk endpoint (public, returns personal data), one is a placeholder login that always returns OK, and one is the Laravel default `/api/user` protected by Sanctum, for which no token can be obtained. All real functionality is exposed only as session-based Blade pages. CONFIRMED.

API group configuration (`app/Http/Kernel.php`, `RouteServiceProvider`): prefix `/api`, middleware `throttle:api` (60/min per user id or IP) + `SubstituteBindings`. `EnsureFrontendRequestsAreStateful` is commented out (no SPA cookie auth). CORS (`config/cors.php`): `paths: api/*, sanctum/csrf-cookie`, `allowed_origins: *`, `supports_credentials: false`.

## 2. Existing endpoints in `routes/api.php`

### 2.1 `POST /api/slanje`
| Aspect | Finding |
|---|---|
| Controller | `App\Http\Controllers\MemberController::slanje` (same method as web `POST /slanje`, `/slanje2`) |
| Authentication | **None** |
| Authorization | **None** |
| Validation | **None**. Reads `postObj.id` (RFID code) and `postObj.gym` from the body |
| Behaviour | Looks up `members.code = postObj.id` joined to `fees` with `end >= today`. If found: toggles attendance (latest attendance `status=1` → sets `out=now,status=0`; else creates a new row with `in=now,status=1,gym=postObj.gym`). If not active: no write. |
| Response | `echo json_encode(...)` (HTTP 200, `Content-Type` text/html): `{"response":[member row + "end"], "id":0, "rok":"d.m.Y"}` for entry, `{"response":[...], "id":1}` for exit, `{"response": <member or null>, "id":2}` for expired/unknown |
| Data returned | `members.*` minus `password`/`remember_token` (model `$hidden`) → **name, surname, code, email, mobile, JMBG, address, image_path, status, is_admin, goals** |
| Related models | `Member`, `Fee`, `Attendance` |
| Mobile-ready? | **No.** |
| Concerns | (1) Anyone on the internet who knows or guesses an RFID code can read that member's personal data including national ID, and can check them in/out. (2) Writes attendance without any device authentication. (3) CORS `*` lets any web page call it from a browser. (4) Not idempotent; no duplicate-scan protection. (5) Non-JSON content type, no status codes (expired member = 200). (6) `gym` is client-supplied and unvalidated. |

### 2.2 `POST /api/login`
| Aspect | Finding |
|---|---|
| Controller | Closure in `routes/api.php` |
| Auth / validation | None |
| Response | Always `{"status":"OK"}` 200 |
| Mobile-ready? | **No — placeholder only.** Does not authenticate anything. Should be removed or replaced in Phase 2. |

### 2.3 `GET /api/user`
| Aspect | Finding |
|---|---|
| Controller | Closure returning `$request->user()` |
| Auth | `auth:sanctum` (`config/sanctum.php` guard `web` → `User` only) |
| Response | Serialised staff `User` |
| Mobile-ready? | **No.** No route issues Sanctum tokens; `Member` lacks `HasApiTokens`; returns staff, not members. Laravel scaffold default. |

## 3. JSON-returning web routes (session + CSRF, not usable from Flutter)

| Method | Route | Controller | Auth | Response | Note |
|---|---|---|---|---|---|
| POST | `/slanje`, `/slanje2` | `MemberController::slanje` | none, CSRF-exempt | as §2.1 | Used by kiosk JS `public/js/main.js` (gym=1), `main2.js` (gym=2) |
| POST | `/live` | `AttendanceController::live2` | `auth` (web) | `{"response":[{ids,name,surname,image_path,in,id,gym}]}` | Polled every 2 s by `public/js/live.js` |
| POST | `/logoutAll` | `AttendanceController::logoutAll` | `auth` (web) | `{"response":"Povratak otpisanih"}` | Checks everyone out |

All other web routes return HTML/redirects with flashed session errors — not reusable as an API.

## 4. Readiness assessment against mobile requirements

| Criterion | Status |
|---|---|
| Token authentication for members | MISSING (Sanctum installed, not wired to `Member`) |
| Consistent JSON envelope | MISSING (`echo json_encode`, mixed shapes) |
| HTTP status codes for errors | MISSING (business errors return 200; validation errors would redirect for non-JSON requests) |
| Validation via FormRequests | MISSING (FormRequest classes are empty stubs) |
| Pagination | Present only in Blade (`paginate()`); no API pagination |
| API Resources / transformers | MISSING (none in `app/Http/Resources`) |
| Rate limiting | `throttle:api` 60/min exists |
| Versioning (`/api/v1`) | MISSING |
| API tests | MISSING |
| Exception rendering for JSON | Laravel default (`Handler` unchanged) — returns JSON when `Accept: application/json` (INFERRED framework behaviour) |

## 5. Proposed future endpoints (NOT implemented — design input for Phase 2)

These are suggestions derived from existing web functionality. Nothing below exists today.

| # | Proposed endpoint | Reuses (existing code) | Notes |
|---|---|---|---|
| 1 | `POST /api/v1/member/login` → token | `MemberAuthController::login` rules (email+password, password not null, active fee) | Sanctum personal access token on `Member`; device name |
| 2 | `POST /api/v1/member/logout` | — | Revoke current token |
| 3 | `GET /api/v1/member/me` | `MemberPortalController::profile` data | Must **exclude** `jmbg`, `code`, `is_admin` unless decided otherwise |
| 4 | `GET /api/v1/member/membership` | latest `fees.end` logic (`ActiveMember`) | Active flag, expiry date, days left |
| 5 | `GET /api/v1/member/fees` | `FeeController::fees` query | Member's own periods/payments, paginated |
| 6 | `GET /api/v1/member/attendance` | `attendances` queries in `MemberPortalController` | Paginated history |
| 7 | `GET /api/v1/member/statistics` | `MemberPortalController::statistics` | Same aggregates as web |
| 8 | `PUT /api/v1/member/settings` | `MemberPortalController::updateSettings` validation | Goals |
| 9 | `POST /api/v1/member/photo` (multipart) | `MemberPortalController::updatePhoto` | Same validation + re-encode |
| 10 | `PUT /api/v1/member/password` | `MemberAuthController::changePassword` | |
| 11 | `POST /api/v1/member/password/forgot` | `MemberAuthController::sendResetLink` | Reset link opens web page |
| 12 | `POST /api/v1/member/activate` | `MemberAuthController::register` | Emails generated password |
| 13 | `GET /api/v1/announcements` | `MemberPortalController::obavijesti` | Paginated; unread count via `last_seen_obavijesti` |
| 14 | `GET /api/v1/trainings` | `MemberPortalController::termini`, `TerminTreninga::sedmicniRaspored()` | Include `prijave_count`, `is_signed_up` |
| 15 | `POST/DELETE /api/v1/trainings/{id}/signup` | `prijaviSe` / `odjaviSe` | Make capacity check atomic |
| 16 | `GET /api/v1/gym/live` | `MemberPortalController::live` | Requires privacy decision (names/photos of others) |
| 17 | `GET /api/v1/member/card` | none | Digital card / QR token — **requires business decision** |
| 18 | `POST /api/v1/member/devices` | none | Register FCM/APNs token for push |
| 19 | Moderator / member-admin endpoints | `ModeratorController`, `MemberPortalController` admin methods | Defer until role model is fixed |

## 6. Security concerns (existing)

1. **Public PII endpoint**: `/slanje`, `/slanje2`, `/api/slanje` return JMBG, email, mobile and address for any valid RFID code, without authentication, CSRF-exempt, with CORS `*` on the API copy. **High.**
2. **Public attendance writes**: same endpoints let anyone check members in/out. **High.**
3. **Public `GET /send-mail`** sends a test email on every hit (abuse/spam vector). **Medium.**
4. **Public `GET /attendance2`** exposes the Ladies-gym kiosk page. **Medium.**
5. **Placeholder `/api/login`** always 200 OK — misleading for clients/tests. **Low.**
6. **Logging of personal data**: `Log::info($request)` / `Log::info($member)` in `MemberController` and `FeeController` writes member records (incl. JMBG on create) to `storage/logs`. **Medium.**
7. **State-changing GET routes**: `/feesDelete/{id}`, `/odjava/{id}`, `/odjava-live/{id}` (auth required, but CSRF-unprotected because GET). **Medium.**
8. **Account enumeration** in member register/forgot-password (distinct error messages). **Low.**
9. **Moderator login without rate limiting.** **Medium.**
10. **Upload file names** keep the client-supplied original name in `public/images/obavijesti/` (see BUSINESS_LOGIC.md §8). **Medium**, INFERRED severity depends on server PHP handler config.
