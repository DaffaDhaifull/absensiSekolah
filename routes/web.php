<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SchoolDataController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
    return redirect()->route('login');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('pengguna', UserController::class);
        Route::get('/laporan', [PresenceController::class, 'showLap'])->name('laporan.index');
        Route::post('/laporan/export', [PresenceController::class, 'export'])->name('laporan.export');
        Route::post('/students/import', [StudentController::class, 'import'])->name('students.import.process');
    });

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('kelas', ClassesController::class);
    Route::resource('siswa', StudentController::class);

    Route::get('/absensi', [PresenceController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [PresenceController::class, 'store'])->name('absensi.store');
    Route::post('/absensi/update', [PresenceController::class, 'update'])->name('absensi.update');

    Route::get('/pesan',[NotificationController::class,'index'])->name('pesan.index');
    Route::get('/profile',[SchoolDataController::class,'index'])->name('profile.index');
    Route::post('/profile',[SchoolDataController::class,'store'])->name('profile.store');
});
