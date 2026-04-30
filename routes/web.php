<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminPortalObavijestController;
use App\Http\Controllers\AdminPortalTerminController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberPortalController;
use App\Http\Controllers\ModeratorAuthController;
use App\Http\Controllers\ModeratorController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('begsfit', function () {
    return view('welcome');
});

Route::post('/slanje2',[MemberController::class, 'slanje'])->name('slanje');

  Route::get('/attendance2', [MemberController::class, 'attendance2'])->name('attendance2');
  Route::post('/slanje', [MemberController::class, 'slanje'])->name('slanje');
Route::group([

    'excluded_middleware' => ['auth'],
  ], function () {


  });
  Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    Mail::to('ahadziahmetovic@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});

//Auth::routes();
Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'prevent-back-history'], function () {

 // Auth::routes();


  Route::middleware(['auth'])->post('/create', [MemberController::class, 'create'])->name('create');
  Route::middleware(['auth'])->post('/updateMember', [MemberController::class, 'updateMember'])->name('updateMember');
  Route::middleware(['auth'])->post('/updateFee', [FeeController::class, 'updateFee'])->name('updateFee');
  Route::middleware(['auth'])->post('/test', [HomeController::class, 'test'])->name('test');
  Route::middleware(['auth'])->get('/home', [HomeController::class, 'index'])->name('home');
  Route::middleware(['auth'])->get('/izvjestaj', [HomeController::class, 'izvjestaj'])->name('izvjestaj');
  Route::middleware(['auth'])->get('/memberProfile', [MemberController::class, 'profile'])->name('profile');
  Route::middleware(['auth'])->get('/createMember', [MemberController::class, 'index'])->name('createMember');
  Route::middleware(['auth'])->get('/createFee/{id}', [FeeController::class, 'index'])->name('createFee');
  Route::middleware(['auth'])->get('/members', [MemberController::class, 'members'])->name('members');
  Route::middleware(['auth'])->get('/attendance', [MemberController::class, 'attendance'])->name('attendance');

  Route::middleware(['auth'])->get('/editMember/{id}', [MemberController::class, 'editMember'])->name('editMember');
  Route::middleware(['auth'])->get('/editFee/{id}', [FeeController::class, 'editFee'])->name('editFee');
  Route::middleware(['auth'])->get('/memberProfile/{id}', [MemberController::class, 'memberProfile'])->name('memberProfile');
  Route::middleware(['auth'])->post('/memberProfile/{id}/settings', [MemberController::class, 'updateProfileSettings'])->name('memberProfile.settings');
  Route::middleware(['auth'])->get('/feesDelete/{id}', [FeeController::class, 'destroy'])->name('feesDelete');
  Route::middleware(['auth'])->get('/attendance-list', [AttendanceController::class, 'index'])->name('attendance-list');
  Route::middleware(['auth'])->get('/attendance-live', [AttendanceController::class, 'live'])->name('attendance-live');
  Route::middleware(['auth'])->get('/fees/{id}', [FeeController::class, 'fees'])->name('fees');
  Route::middleware(['auth'])->post('/logoutAll', [AttendanceController::class, 'logoutAll'])->name('logoutAll');
 // Route::middleware(['auth'])->post('/slanje', [MemberController::class, 'slanje'])->name('slanje');
  Route::middleware(['auth'])->post('live', [AttendanceController::class, 'live2'])->name('live');
    Route::middleware(['auth'])->get('/search', [MemberController::class, 'search'])->name('search');
  Route::middleware(['auth'])->delete('/deleteMember/{member}', [MemberController::class, 'destroy'])->name('deleteMember');
  Route::middleware(['auth'])->get('/odjava/{id}', [AttendanceController::class, 'odjava'])->name('odjava');
  Route::middleware(['auth'])->get('/odjava-live/{id}', [AttendanceController::class, 'odjavalive'])->name('odjava-live');
  Route::middleware(['auth'])->get('/report', [AttendanceController::class, 'report'])->name('report');
  Route::middleware(['auth'])->get('/comparison', [AttendanceController::class, 'comparison'])->name('comparison');
  Route::middleware(['auth'])->post('/insertFee', [FeeController::class, 'insertFee'])->name('insertFee');
  Route::middleware(['auth'])->post('/odjaviNeaktivne', [AttendanceController::class, 'odjaviNeaktivne'])->name('odjaviNeaktivne');
  Route::middleware(['auth'])->get('/admin/portal-obavijesti', [AdminPortalObavijestController::class, 'index'])->name('admin.portal.obavijesti');
  Route::middleware(['auth'])->post('/admin/portal-obavijesti', [AdminPortalObavijestController::class, 'store'])->name('admin.portal.obavijesti.store');
  Route::middleware(['auth'])->get('/admin/portal-obavijesti/{obavijest}/edit', [AdminPortalObavijestController::class, 'edit'])->name('admin.portal.obavijesti.edit');
  Route::middleware(['auth'])->put('/admin/portal-obavijesti/{obavijest}', [AdminPortalObavijestController::class, 'update'])->name('admin.portal.obavijesti.update');
  Route::middleware(['auth'])->delete('/admin/portal-obavijesti/{obavijest}', [AdminPortalObavijestController::class, 'destroy'])->name('admin.portal.obavijesti.destroy');
  Route::middleware(['auth'])->get('/admin/portal-termini', [AdminPortalTerminController::class, 'index'])->name('admin.portal.termini');
  Route::middleware(['auth'])->post('/admin/portal-termini', [AdminPortalTerminController::class, 'store'])->name('admin.portal.termini.store');
  Route::middleware(['auth'])->get('/admin/portal-termini/{termin}/edit', [AdminPortalTerminController::class, 'edit'])->name('admin.portal.termini.edit');
  Route::middleware(['auth'])->put('/admin/portal-termini/{termin}', [AdminPortalTerminController::class, 'update'])->name('admin.portal.termini.update');
  Route::middleware(['auth'])->delete('/admin/portal-termini/{termin}', [AdminPortalTerminController::class, 'destroy'])->name('admin.portal.termini.destroy');


});

// ===== Member Portal Routes =====
Route::prefix('portal')->group(function () {
    Route::get('/login', [MemberAuthController::class, 'showLoginForm'])->name('member.login');
    Route::post('/login', [MemberAuthController::class, 'login'])->name('member.login.submit');
    Route::get('/register', [MemberAuthController::class, 'showRegisterForm'])->name('member.register');
    Route::post('/register', [MemberAuthController::class, 'register'])->name('member.register.submit');
    Route::post('/logout', [MemberAuthController::class, 'logout'])->name('member.logout');

    Route::middleware(['active.member'])->group(function () {
        Route::get('/profile', [MemberPortalController::class, 'profile'])->name('member.profile');
      Route::post('/profile/photo', [MemberPortalController::class, 'updatePhoto'])->name('member.profile.photo');
        Route::get('/pravila', [MemberPortalController::class, 'rules'])->name('member.rules');
        Route::get('/settings', [MemberPortalController::class, 'settings'])->name('member.settings');
        Route::post('/settings', [MemberPortalController::class, 'updateSettings'])->name('member.settings.update');
        Route::get('/statistics', [MemberPortalController::class, 'statistics'])->name('member.statistics');
        Route::get('/live', [MemberPortalController::class, 'live'])->name('member.live');
        Route::get('/obavijesti', [MemberPortalController::class, 'obavijesti'])->name('member.obavijesti');
        Route::get('/termini', [MemberPortalController::class, 'termini'])->name('member.termini');
        Route::post('/termini/{termin}/prijava', [MemberPortalController::class, 'prijaviSe'])->name('member.termini.prijava');
        Route::post('/termini/{termin}/odjava', [MemberPortalController::class, 'odjaviSe'])->name('member.termini.odjava');
        Route::get('/change-password', [MemberAuthController::class, 'showChangePasswordForm'])->name('member.password');
        Route::post('/change-password', [MemberAuthController::class, 'changePassword'])->name('member.password.update');

        // Admin routes for members with is_admin = true
        Route::middleware(['admin.member'])->group(function () {
            Route::get('/obavijesti/kreiraj', [MemberPortalController::class, 'createObavijest'])->name('member.obavijesti.create');
            Route::post('/obavijesti', [MemberPortalController::class, 'storeObavijest'])->name('member.obavijesti.store');
            Route::get('/obavijesti/{obavijest}/uredi', [MemberPortalController::class, 'editObavijest'])->name('member.obavijesti.edit');
            Route::put('/obavijesti/{obavijest}', [MemberPortalController::class, 'updateObavijest'])->name('member.obavijesti.update');
            Route::delete('/obavijesti/{obavijest}', [MemberPortalController::class, 'deleteObavijest'])->name('member.obavijesti.delete');

            Route::get('/termini/kreiraj', [MemberPortalController::class, 'createTermin'])->name('member.termini.create');
            Route::post('/termini', [MemberPortalController::class, 'storeTermin'])->name('member.termini.store');
            Route::get('/termini/{termin}/uredi', [MemberPortalController::class, 'editTermin'])->name('member.termini.edit');
            Route::put('/termini/{termin}', [MemberPortalController::class, 'updateTermin'])->name('member.termini.update');
            Route::delete('/termini/{termin}', [MemberPortalController::class, 'deleteTermin'])->name('member.termini.delete');
        });
    });
});

// ===== Moderator Routes =====
Route::prefix('moderator')->group(function () {
    Route::get('/login', [ModeratorAuthController::class, 'showLoginForm'])->name('moderator.login');
    Route::post('/login', [ModeratorAuthController::class, 'login'])->name('moderator.login.submit');
    Route::post('/logout', [ModeratorAuthController::class, 'logout'])->name('moderator.logout');

    Route::middleware(['auth.moderator'])->group(function () {
        Route::get('/', [ModeratorController::class, 'dashboard'])->name('moderator.dashboard');

        Route::get('/obavijesti', [ModeratorController::class, 'obavijesti'])->name('moderator.obavijesti');
        Route::get('/obavijesti/kreiraj', [ModeratorController::class, 'createObavijest'])->name('moderator.obavijesti.create');
        Route::post('/obavijesti', [ModeratorController::class, 'storeObavijest'])->name('moderator.obavijesti.store');
        Route::get('/obavijesti/{obavijest}/uredi', [ModeratorController::class, 'editObavijest'])->name('moderator.obavijesti.edit');
        Route::put('/obavijesti/{obavijest}', [ModeratorController::class, 'updateObavijest'])->name('moderator.obavijesti.update');
        Route::delete('/obavijesti/{obavijest}', [ModeratorController::class, 'deleteObavijest'])->name('moderator.obavijesti.delete');

        Route::get('/termini', [ModeratorController::class, 'termini'])->name('moderator.termini');
        Route::get('/termini/kreiraj', [ModeratorController::class, 'createTermin'])->name('moderator.termini.create');
        Route::post('/termini', [ModeratorController::class, 'storeTermin'])->name('moderator.termini.store');
        Route::get('/termini/{termin}/uredi', [ModeratorController::class, 'editTermin'])->name('moderator.termini.edit');
        Route::put('/termini/{termin}', [ModeratorController::class, 'updateTermin'])->name('moderator.termini.update');
        Route::delete('/termini/{termin}', [ModeratorController::class, 'deleteTermin'])->name('moderator.termini.delete');
        Route::get('/termini/{termin}/prijave', [ModeratorController::class, 'terminPrijave'])->name('moderator.termini.prijave');
    });
});
