<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('calendars.show', ['user_id' => auth()->user()->id]);
})->middleware(['auth', 'verified'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('calendars/{user_id}/{calendar?}', [CalendarController::class, 'show'])
    ->name('calendars.show');

Route::post('calendars', [CalendarController::class, 'store'])
    ->name('calendars.store');

Route::put('calendars/{user_id}/{calendar}', [CalendarController::class, 'update'])
    ->name('calendars.update');

Route::post('tasks', [TaskController::class, 'store'])
    ->name('tasks.store');