/**หลัง */
<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/** กลุ่มเส้นทาง (Route Groups) ที่ต้องเข้าสู่ระบบ */
    Route::middleware('auth')->group(function () /**พื่อให้เข้าถึงได้เฉพาะผู้ที่เข้าสู่ระบบแล้ว */ {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); /**สำหรับอัปเดตโปรไฟล์ */
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); /**สำหรับลบโปรไฟล์ */
});
/**สร้างเส้นทางสำหรับการทำงานกับ chirps
 * index: แสดงรายการ Chirps
store: บันทึก Chirp ใหม่
update: แก้ไข Chirp
 */
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

    /** โหลดเส้นทางการยืนยันตัวตน */
require __DIR__.'/auth.php';
