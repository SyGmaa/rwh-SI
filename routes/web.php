<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/users/login', function () {
    return view('users.login');
})->name('users.login');

Route::get('/users/signup', [App\Http\Controllers\UserController::class, 'showSignupForm'])->name('users.signup');
Route::post('/users/signup', [App\Http\Controllers\UserController::class, 'signup'])->name('users.signup.post');

Route::get('/users/forgot-password', function () {
    return view('users.forgot-password');
})->name('users.forgot-password');

Route::post('/users/forgot-password', [App\Http\Controllers\UserController::class, 'sendResetLinkEmail'])->name('users.forgot-password.post');

Route::get('/users/reset-password/{token}', [App\Http\Controllers\UserController::class, 'showResetPasswordForm'])->name('users.reset-password');
Route::post('/users/reset-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('users.reset-password.post');

Route::get('/users/two-factor', function () {
    return view('users.two-factor-autentication');
})->name('users.two-factor');

Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar-events', [\App\Http\Controllers\CalendarController::class, 'getEvents'])->name('calendar.events');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('jenis-paket', \App\Http\Controllers\JenisPaketController::class);
    Route::resource('paket', \App\Http\Controllers\PaketController::class);
    Route::resource('jadwal-keberangkatan', \App\Http\Controllers\JadwalKeberangkatanController::class);
    Route::resource('pendaftaran', \App\Http\Controllers\PendaftaranController::class);
    Route::resource('jemaah', \App\Http\Controllers\JemaahController::class);
    Route::resource('cicilan-jemaah', \App\Http\Controllers\CicilanJemaahController::class);
    Route::resource('jenis-dokumen', \App\Http\Controllers\JenisDokumenController::class);
    Route::resource('dokumen-jemaah', \App\Http\Controllers\DokumenJemaahController::class);
    Route::resource('log-activity', \App\Http\Controllers\LogActivityController::class);
});
