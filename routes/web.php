<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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

Route::name('project.')->middleware('auth')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/create', [ProjectController::class, 'create']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit']);
    Route::patch('/projects/{project}', [ProjectController::class, 'update']);
    Route::name('task.')->group(function() {
        Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'store'])->name('index');
        Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'update'])->name('update');
        Route::delete('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'destroy'])->name('update');
    });
});



require __DIR__.'/auth.php';
