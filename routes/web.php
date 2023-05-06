<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [Controller::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
    Route::resource('announcement', \App\Http\Controllers\AnnouncementController::class);
    Route::resource('comment', \App\Http\Controllers\CommentController::class);
    Route::post('/comment/store',[commentController::class, 'store'])->name('comment.store');
    Route::resource('lesson', \App\Http\Controllers\LessonController::class);
    Route::get('/finished_lesson/{lesson}', [lessonController::class, 'finished_show'])->name('finished_show');
    Route::get('/future_lesson/{lesson}', [lessonController::class, 'future_show'])->name('future_show');
    Route::post('lesson/store',[lessonController::class, 'store'])->name('lesson.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
