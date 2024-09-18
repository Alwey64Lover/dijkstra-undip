<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
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

Route::get('/', [AuthenticatedSessionController::class, 'checkLogin']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('modules.backend.dashboard');
    })
        ->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware(['roles:superadmin|dean'])->group(function () {
        Route::simpleResource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
