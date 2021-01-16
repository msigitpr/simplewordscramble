<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

Route::get('/', [MainController::class, 'index']);
Route::post('/check', [MainController::class, 'check'])->name('check');
Route::post('/score', [MainController::class, 'score'])->name('score');

Route::get('/dashboard', [MainController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
