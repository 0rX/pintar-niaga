<?php

use App\Http\Controllers;
use App\Http\Controllers\welcome;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\logincanvas;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RemoveOCVFlag;
use App\Http\Controllers\Staff\StaffDashboard;
use App\Http\Controllers\Management\ManagementDashboard;

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


Auth::routes();

Route::get('/', [welcome::class, 'welcome'])->name('welcome');

Route::get('/remove-ocv-flag', [RemoveOCVFlag::class, 'removeOCVFlag'])->name('removeOCVFlag');

Route::post('/logincanvas', [logincanvas::class, 'logincanvas'])->name('logincanvas');

/**
 * Route accessible by 'staff' role only
 */
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [StaffDashboard::class, 'dashboard'])->name('staffDashboard');
});

/**
 * Route accessible by 'manager' role only
 */
Route::prefix('management')->middleware(['auth', 'role:manager,staff'])->group(function() {
    Route::get('/', [ManagementDashboard::class, 'index'])->name('managementDashboard');
});