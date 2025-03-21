<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::get("/" , static function () {
    return to_route("tasks.index");
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('tasks/my-tasks', [TaskController::class, 'myTasks'])
        ->name('tasks.my-tasks');
    Route::get('tasks/assigned-tasks', [TaskController::class, 'assignTasks'])
        ->name('tasks.assigned-tasks');
    Route::resource('tasks', TaskController::class)
        ->missing(function (Request $request) {
            return redirect()->route('tasks.index');
        });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
