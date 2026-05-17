<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

$taskIdRoute = '/tasks/{id}';

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');
Route::get('/tasks/completed', [TaskController::class, 'completed'])->name('tasks.completed');
Route::get('/tasks/pending', [TaskController::class, 'pending'])->name('tasks.pending');
Route::get('/calendar', [TaskController::class, 'calendar'])->name('calendar');
Route::get('/analytics', [TaskController::class, 'analytics'])->name('analytics');
Route::get('/settings', [TaskController::class, 'settings'])->name('settings');
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('tasks.index')->with('success', 'Logged out successfully.');
})->name('logout');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get($taskIdRoute, [TaskController::class, 'show'])->name('tasks.show');
Route::get($taskIdRoute . '/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put($taskIdRoute, [TaskController::class, 'update'])->name('tasks.update');
Route::delete($taskIdRoute, [TaskController::class, 'destroy'])->name('tasks.destroy');
