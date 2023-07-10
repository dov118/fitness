<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MuscleController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/login/discord', [LoginController::class, 'loginDiscord'])->name('login.discord');
Route::get('/login/discord/oauth', [LoginController::class, 'loginDiscordOAuth'])->name('login.discord.oauth');
Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(callback: function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('index');

    Route::resource('group', GroupController::class);
    Route::resource('muscle', MuscleController::class);
    Route::resource('exercise', ExerciseController::class);
});
