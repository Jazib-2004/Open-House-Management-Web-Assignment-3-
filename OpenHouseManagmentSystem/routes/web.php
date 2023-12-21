<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailsController;
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
    return view('start');
});
Route::get('/login', function () {
    return view('login');
});
Route::post('/login',[AuthController::class,"login"]);
Route::get('/registeration', function () {
    return view('registeraton');
})->name('registeration');
Route::post('/registeration',[AuthController::class,"register"]);



Route::get("/studetails/{id?}",[DetailsController::class,"stu_page"]);
// Route::get("/add_stu/{id?}",[DetailsController::class,"add_project"]);
Route::post("/update_stu/{id?}",[DetailsController::class,"update_project"]);
Route::post("/add_stu/{id?}",[DetailsController::class,"add_project"]);


Route::get("/landing/{id?}",[DetailsController::class,"show_project"]);
Route::post("/set_location",[DetailsController::class,"setLocation"]);
Route::post("/add_rubrics",[DetailsController::class,"addRubrics"]);

Route::get('/evaluator/preferences/{id?}', [DetailsController::class, 'set_preferences']);
Route::post('/save_prefer/{id?}', [DetailsController::class, 'preferences']);
Route::get('/evaluator/projects', [DetailsController::class, 'viewProjects']);
Route::post('/evaluator/evaluate', [DetailsController::class, 'evaluateProject']);
Route::post('/rate/{id?}', [DetailsController::class, 'rate']);

Route::post("/landing",[DetailsController::class,"setLocation"]);

