<?php

use App\Http\Controllers\AcademicRoomController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CourseDepartmentController;
use App\Http\Controllers\CourseDepartmentDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\IrsController;
use App\Http\Controllers\RoomController;
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
        Route::get('/newschedule', [CourseDepartmentDetailController::class, 'new_sched'])->name('newschedule');
        Route::get('/courses', [CourseDepartmentDetailController::class, 'display_course'])->name('courses');
        Route::get('/course/{action}', [CourseDepartmentDetailController::class, 'form'])->name('newcourse');
        Route::post('/coursenew', [CourseDepartmentDetailController::class, 'course_store'])->name('storecourse');
        Route::post('/courseupdate/{id}', [CourseDepartmentDetailController::class, 'course_update'])->name('updatecourse');
        Route::delete('/coursedelete/{id}', [CourseDepartmentDetailController::class, 'course_destroy'])->name('deletecourse');
        Route::get('/courses/filter', action: [CourseDepartmentDetailController::class, 'filter'])->name('filtercourse');
        Route::post('/check-schedule', [CourseDepartmentDetailController::class,'schedule_check']);
        Route::post('/store-schedule', [CourseDepartmentDetailController::class, 'schedule_store']);
        Route::get('/get-schedules', [CourseDepartmentDetailController::class, 'display_schedules']);
        Route::delete('/delete-schedule/{id}', [CourseDepartmentDetailController::class, 'schedule_destroy']);
        Route::post('/check-room-availability', [CourseDepartmentDetailController::class, 'checkRoomAvailability']);
        Route::post('/submit-schedule', [CourseDepartmentDetailController::class, 'submitSchedule']);
        Route::get('/check-submission-status', [CourseDepartmentDetailController::class, 'checkSubmissionStatus']);
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

    Route::middleware(['roles:dean'])->group(function () {
        Route::get('department-schedule', [CourseDepartmentController::class, 'index'])->name('department-schedule.index');
        Route::post('department-schedule/accept-some', [CourseDepartmentController::class, 'acceptSome'])->name('department-schedule.accept-some');
        Route::get('department-schedule/accept-or-reject/{id}/{status}', [CourseDepartmentController::class, 'acceptOrReject'])->name('department-schedule.accept-or-reject');
        Route::get('department-schedule/{id}', [CourseDepartmentController::class, 'show'])->name('department-schedule.show');
        Route::get('/get-schedules-dean', [CourseDepartmentDetailController::class, 'display_schedules']);

        Route::get('academic-room', [RoomController::class, 'index'])->name('academic-room.index');
        Route::get('academic-room/{id}/accept', [RoomController::class, 'accept'])->name('academic-room.accept');
    });

    Route::middleware(['roles:academic_division'])->group(function () {
        // view dan add
        // Route::get('/addrooms', [RoomController::class, 'index'])->name('newroom');
        Route::get('/room', [RoomController::class, 'index'])->name('room.index');
        Route::get('/room/create-room', [RoomController::class, 'create'])->name('add-room');
        Route::post('/simpan-room', [RoomController::class, 'store'])->name('simpan-room');
        // edit
        Route::get('/edit/{id}', [RoomController::class, 'edit'])->name('edit-room');
        Route::get('/room/{id}/submit', [RoomController::class, 'submit'])->name('room.submit');
        Route::put('/update/{id}', [RoomController::class, 'update'])->name('update-room');

        Route::delete('/delete/{id}', [RoomController::class, 'destroy'])->name('room-destroy');

        Route::simpleResource('users', UserController::class);

    });
});

require __DIR__.'/auth.php';
