<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CourseDepartmentDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Models\HerRegistration;
use App\Models\Khs;
use App\Models\Student;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('dashboard');


    //PALA DEPT
    Route::get('/CourseDepartmentDetail/create', [CourseDepartmentDetailController::class, 'create'])->name('CourseDepartmentDetail.create');

    //END OF PALA DEPT
    
    Route::get('students/search/{lecturerId?}', [StudentController::class, 'search'])->name('students.search');
    // Route::get('dashboard', [DepartmentController::class, 'getAllClasses']);

    // temporary
    Route::post('/irs', [LecturerController::class, 'showStudentIrs'])->name('lecturer.irs');

    // temporary
    Route::post('/khs', [LecturerController::class, 'showStudentKhs'])->name('lecturer.khs');

    Route::middleware(['roles:superadmin|dean'])->group(function () {
        Route::simpleResource('users', UserController::class);
    });
});


require __DIR__.'/auth.php';
