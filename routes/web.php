<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/teams/create', [TeamController::class, 'create'])
        ->name('teams.create');

    Route::post('/teams', [TeamController::class, 'store'])
        ->name('teams.store');

    Route::get('/teams/join', [TeamController::class, 'join'])
        ->name('teams.join');

    Route::post('/teams/join', [TeamController::class, 'storeJoin'])
        ->name('teams.join.store');

    Route::get('/teams/manage', [TeamController::class, 'manage'])
        ->name('teams.manage');

    Route::post('/teams/{team}/select', [TeamController::class, 'select'])
        ->name('teams.select');

    Route::get('/teams/{team}/workspace', [TeamController::class, 'workspace'])
        ->name('teams.workspace');

    Route::get('/teams/{team}/tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::post('/teams/{team}/tasks', [TaskController::class, 'store'])
        ->name('tasks.store');

    Route::get('/teams/{team}/tasks/{task}', [TaskController::class, 'show'])
        ->name('tasks.show');

    Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])
        ->middleware('role:lider')
        ->name('teams.edit');

    Route::put('/teams/{team}', [TeamController::class, 'update'])
        ->middleware('role:lider')
        ->name('teams.update');

    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])
        ->middleware('role:lider')
        ->name('teams.destroy');

    Route::delete(
        '/teams/{team}/members/{user}',
        [TeamController::class, 'removeMember']
    )
        ->name('teams.members.destroy');


    Route::patch(
        '/teams/{team}/members/{member}/role',
        [TeamController::class, 'changeMemberRole']
    )
        ->name('teams.members.role');
});

require __DIR__.'/auth.php';