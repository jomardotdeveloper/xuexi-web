<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EndAssessmentController;
use App\Http\Controllers\EndDashboardController;
use App\Http\Controllers\EndLessonController;
use App\Http\Controllers\EndLoginController;
use App\Http\Controllers\EndQuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;

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
    return view('login');
});

Route::resource('students', StudentController::class);
Route::resource('admins', AdminController::class);
Route::get('/ ', [LoginController::class, 'login'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');

Route::get('/firebase', [FirebaseController::class, 'create']);

/*
|--------------------------------------------------------------------------
| Web Routes for second version
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::prefix('end')->group(function () {
    Route::get('/elogin', [EndLoginController::class, 'login'])->name('end.login');
    Route::post('/elogin', [EndLoginController::class, 'authenticate'])->name('end.authenticate');
    Route::post('/elogout', [EndLoginController::class, 'logout'])->name('end.logout');
    Route::get('/dashboard', [EndDashboardController::class, 'index'])->name('end.dashboard');
    Route::get('/assessment', [EndAssessmentController::class, 'index'])->name('end.assessment');
    Route::post('/assessment', [EndAssessmentController::class, 'store'])->name('end.assessment.store');
    Route::get('/lesson', [EndLessonController::class, 'index'])->name('end.lesson');
    Route::get('/quiz', [EndQuizController::class, 'index'])->name('end.quiz');
    Route::post('/quiz', [EndQuizController::class, 'store'])->name('end.quiz.store');
});
