<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/', [App\Http\Controllers\welcome::class, 'welcome'])->name('welcome');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');

Route::get('/remove-ocv-flag', [Controllers\RemoveOCVFlag::class, 'removeOCVFlag'])->name('removeOCVFlag');

Route::post('/logincanvas', [Controllers\logincanvas::class, 'logincanvas'])->name('logincanvas');
