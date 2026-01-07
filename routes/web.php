<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\JenisPaketController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\JadwalKeberangkatanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\JemaahController;
use App\Http\Controllers\CicilanJemaahController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\DokumenJemaahController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;

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


Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data')->middleware('auth');
Route::get('/dashboard/top-packages', [DashboardController::class, 'getTopPackagesData'])->name('dashboard.top-packages')->middleware('auth');

Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar-events', [CalendarController::class, 'getEvents'])->name('calendar.events');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
    Route::delete('/profile/other-browser-sessions', [ProfileController::class, 'logoutOtherBrowserSessions'])->name('admin.profile.browser-sessions.destroy');
    Route::delete('/profile', [ProfileController::class, 'deleteUser'])->name('admin.profile.destroy');

    // Manual Fortify Routes Fix
    Route::post('/user/two-factor-authentication', [Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::class, 'store'])
        ->name('two-factor.enable');

    Route::post('/user/confirmed-two-factor-authentication', [Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::class, 'store'])
        ->name('two-factor.confirm');

    Route::delete('/user/two-factor-authentication', [Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::class, 'destroy'])
        ->name('two-factor.disable');

    Route::get('/user/two-factor-qr-code', [Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController::class, 'show'])
        ->name('two-factor.qr-code');

    Route::get('/user/two-factor-recovery-codes', [Laravel\Fortify\Http\Controllers\RecoveryCodeController::class, 'index'])
        ->name('two-factor.recovery-codes');

    Route::post('/user/two-factor-recovery-codes', [Laravel\Fortify\Http\Controllers\RecoveryCodeController::class, 'store'])
        ->name('two-factor.recovery-codes.store');


    Route::resource('jenis-paket', JenisPaketController::class);
    Route::resource('paket', PaketController::class);
    Route::resource('jadwal-keberangkatan', JadwalKeberangkatanController::class);
    Route::resource('pendaftaran', PendaftaranController::class);
    Route::resource('jemaah', JemaahController::class);
    Route::get('/jemaah/dokumen/{id}/preview', [JemaahController::class, 'previewFile'])->name('jemaah.dokumen.preview');
    Route::get('cicilan-jemaah/{id}/cetak', [CicilanJemaahController::class, 'cetakKwitansi'])->name('cicilan-jemaah.cetak');
    Route::resource('cicilan-jemaah', CicilanJemaahController::class);
    Route::resource('jenis-dokumen', JenisDokumenController::class);
    Route::resource('dokumen-jemaah', DokumenJemaahController::class);
    Route::resource('log-activity', LogActivityController::class);
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::resource('user-management', UserManagementController::class);
    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan.index');
    Route::get('/laporan-keuangan/export-excel', [LaporanKeuanganController::class, 'exportExcel'])->name('laporan-keuangan.export-excel');
    Route::get('/laporan-keuangan/export-pdf', [LaporanKeuanganController::class, 'exportPdf'])->name('laporan-keuangan.export-pdf');

    // Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/backup', [SettingController::class, 'backup'])->name('settings.backup');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});
