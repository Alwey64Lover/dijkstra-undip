<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Models\Khs;
use App\Models\Student;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('students/search/{lecturerId?}', [StudentController::class, 'search'])->name('students.search');
    // Route::get('dashboard', [DepartmentController::class, 'getAllClasses']);

    // temporary
    Route::get('/{student:nim}/irs', function (Student $student) {
        return view('modules.irs', [
            "title" => "IRS",
            "student" => $student
         ]);
    });

    // temporary
    Route::get('/{student:nim}/khs', function (Student $student) {
        return view('modules.khs', [
            "title" => "KHS",
            "student" => $student,
            "khs" => Khs::with(['irsDetail.irs.herRegistration.student' => function ($query) use ($student){
                $query->where('nim', $student->nim);
            }])->get()
        ]);
    });

    Route::middleware(['roles:superadmin|dean'])->group(function () {
        Route::simpleResource('users', UserController::class);
    });
});


require __DIR__.'/auth.php';
