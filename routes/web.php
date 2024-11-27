<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CourseDepartmentDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\IrsController;
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
    Route::middleware(['roles:head_of_department'])->group(function () {
        Route::simpleResource('schedule', CourseDepartmentDetailController::class);
        Route::get('/course/{action}', [CourseDepartmentDetailController::class, 'form'])->name('newcourse');
        Route::get('/newschedule', [CourseDepartmentDetailController::class, 'new_sched'])->name('newschedule');
        Route::get('/courses', [CourseDepartmentDetailController::class, 'display_course'])->name('courses');
    });

    //END OF PALA DEPT

    // Route::get('students/search/{lecturerId?}', [StudentController::class, 'search'])->name('students.search');
    // // Route::get('dashboard', [DepartmentController::class, 'getAllClasses']);

    // // temporary
    // Route::post('/irs', [LecturerController::class, 'showStudentIrs'])->name('lecturer.irs');

    // // temporary
    // Route::post('/khs', [LecturerController::class, 'showStudentKhs'])->name('lecturer.khs');
    Route::middleware(['roles:lecturer'])->group(function () {
        Route::get('students/search/{lecturerId?}', [StudentController::class, 'search'])->name('students.search');
        // Route::get('dashboard', [DepartmentController::class, 'getAllClasses']);

        Route::get('/irs/{irs:id}/accept', [IrsController::class, 'accept'])->name('irs.accept');
        Route::get('/irs/{irs:id}/reject', [IrsController::class, 'reject'])->name('irs.reject');

        Route::get('/irs/{irs:id}/open', [IrsController::class, 'open'])->name('irs.open');
        Route::get('/irs/{irs:id}/close', [IrsController::class, 'close'])->name('irs.close');

        Route::get('/irs/{nim}', [LecturerController::class, 'showStudentIrs'])->name('lecturer.irs');

        Route::get('/khs/{nim}', [LecturerController::class, 'showStudentKhs'])->name('lecturer.khs');
    });

    Route::middleware(['roles:superadmin|dean'])->group(function () {
        Route::simpleResource('users', UserController::class);
    });
});


require __DIR__.'/auth.php';
