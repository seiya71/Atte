<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

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


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
});

Route::post('/work/start', [AttendanceController::class, 'startWork'])->name('work.start');
Route::post('/work/end/{attendanceId}', [AttendanceController::class, 'endWork'])->name('work.end');
Route::post('/break/start/{attendanceId}', [AttendanceController::class, 'startBreak'])->name('break.start');
Route::post('/break/end/{breakId}', [AttendanceController::class, 'endBreak'])->name('break.end');

Route::get('/attendance/{date?}', [AttendanceController::class, 'show'])->name('attendance.show');