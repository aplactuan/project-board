<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInviteController;
use App\Http\Controllers\ProjectTasksController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('projects.')->middleware('auth')->group(function () {
    Route::resource('/projects', ProjectController::class);
    Route::post('/projects/{project}/invite', ProjectInviteController::class)->name('invite');
    Route::name('task.')->group(function() {
        Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'store'])->name('add');
        Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'update'])->name('update');
        Route::delete('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'destroy'])->name('delete');
    });
});



require __DIR__.'/auth.php';
