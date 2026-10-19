<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/slanje', [MemberController::class, 'slanje']);

Route::post('/login', function (Request $request) {

    return response()->json(['status' => 'OK'], 200);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| Mobilna aplikacija za clanove - API v1
|--------------------------------------------------------------------------
| Token autentikacija (Sanctum) preko guarda `member_api` (provider: members).
| Pravila su ista kao u web portalu (/portal). Rute iznad ostaju nepromijenjene.
*/
Route::prefix('v1/member')->middleware('force.json')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\V1\Member\AuthController::class, 'login'])->middleware('throttle:10,10');
    Route::post('/activate', [\App\Http\Controllers\Api\V1\Member\AuthController::class, 'activate'])->middleware('throttle:5,10');
    Route::post('/password/forgot', [\App\Http\Controllers\Api\V1\Member\AuthController::class, 'forgotPassword'])->middleware('throttle:5,10');

    Route::middleware(['auth:member_api'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Api\V1\Member\AuthController::class, 'logout']);

        Route::middleware(['active.member.api'])->group(function () {
            Route::get('/me', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'me']);
            Route::get('/dashboard', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'dashboard']);
            Route::get('/statistics', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'statistics']);
            Route::get('/badges', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'badges']);
            Route::get('/settings', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'settings']);
            Route::put('/settings', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'updateSettings']);
            Route::post('/photo', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'updatePhoto']);
            Route::put('/password', [\App\Http\Controllers\Api\V1\Member\ProfileController::class, 'changePassword']);

            Route::get('/live', [\App\Http\Controllers\Api\V1\Member\GymController::class, 'live']);
            Route::get('/announcements', [\App\Http\Controllers\Api\V1\Member\GymController::class, 'announcements']);
            Route::get('/announcements/{obavijest}', [\App\Http\Controllers\Api\V1\Member\GymController::class, 'announcement']);
            Route::get('/trainings', [\App\Http\Controllers\Api\V1\Member\GymController::class, 'trainings']);
            Route::post('/trainings/{termin}/signup', [\App\Http\Controllers\Api\V1\Member\GymController::class, 'signUp']);
            Route::delete('/trainings/{termin}/signup', [\App\Http\Controllers\Api\V1\Member\GymController::class, 'cancel']);
        });
    });
});
