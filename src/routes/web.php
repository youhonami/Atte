<?php

use App\Http\Controllers\PunchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BreakController;
use App\Http\Controllers\UserController;

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

Route::get('/', [PunchController::class, 'punch']);
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');

Route::post('/attendance/start', [AttendanceController::class, 'startAttendance']);
Route::post('/attendance/end', [AttendanceController::class, 'end'])->name('attendance.end');

Route::post('/attendance/break/start', [BreakController::class, 'breakStart'])->middleware('auth');
Route::post('/attendance/break/end', [BreakController::class, 'breakEnd']);

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');

// ユーザー一覧ページ
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// 特定ユーザーの勤怠実績ページ
Route::get('/users/{user}/attendance', [UserController::class, 'attendance'])->name('users.attendance');

Route::get('/users/{id}/attendance', [
    'uses' => 'AttendanceController@showUserAttendance',
    'as' => 'user.attendance'
]);
