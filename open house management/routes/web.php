<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;

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
    return view('index');
});

Route::get('/login',[ViewController::class,'viewLoginForm'])->name('login');

Route::get('/register', [ViewController::class,'viewRegistrationForm']);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/student/project', [ProjectController::class, 'showStudentProject'])->name('student.project.show');
    Route::get('/student/project/edit', [ProjectController::class, 'editProject'])->name('student.project.edit');
    Route::post('/student/project', [ProjectController::class, 'storeStudentProject'])->name('student.project.store');
    Route::put('/student/project/update', [ProjectController::class, 'updateProject'])->name('student.project.update');

    // Show the details of the student project
    Route::get('/student/project/details', [ProjectController::class, 'showProjectDetails'])->name('student.project.details');

    Route::get('/guest/home', [GuestController::class,'index'])->name('guest.home');
    Route::get('/guest/preferences', [GuestController::class, 'preferences'])->name('guest.preferences');
    Route::get('/guest/preferences/edit', [GuestController::class, 'editPreferences'])->name('guest.edit');
    Route::post('/guest/preferences', [GuestController::class, 'store'])->name('guest.preferences.store');
    Route::put('/guest/preferences', [GuestController::class, 'edit']);
    Route::post('/guest/rate', [GuestController::class, 'rateProject']);

    Route::get('/admin/dashboard', [ProjectController::class,'index'])->name('admin.home');
    Route::get('/projects/{project}/evaluations', [ProjectController::class, 'showEvaluations'])
        ->name('projects.showEvaluations');
        
 
    Route::get('/projects/available-locations', [ProjectController::class, 'availableLocations']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);

    Route::post('/assign-location/{projectId}/{locationId}', [ProjectController::class, 'assignLocation']);

});

//Route for logging in
Route::post('/user/authenticate',[UserController::class,'authenticate']);
//Route for user Registeration
Route::post('/user/register',[UserController::class,'createUser']);
//Route for user logout
Route::post('/user/logout',[UserController::class,'logout']);