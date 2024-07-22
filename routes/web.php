<?php

use App\Http\Controllers\AlgoSessionController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\GithubAccountController;
use App\Http\Controllers\GithubRepositoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlanSubscriptionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function () {
    return 'test';
});

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/message/create', [MessageController::class, 'create'])
        ->name('message.create');

    Route::post('/message/store', [MessageController::class, 'store'])
        ->name('message.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/pricing', [PlanController::class, 'pricing'])
        ->name('pricing');

    Route::get('/plan/info', [PlanController::class, 'info'])
        ->name('plan.info');

    Route::post('/plan/subscriptions/store', [PlanSubscriptionController::class, 'store'])
        ->name('plan-subscriptions.store');

    Route::post('/plan/subscriptions/process', [PlanSubscriptionController::class, 'process'])
        ->name('plan-subscriptions.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/github/accounts/list', [GithubAccountController::class, 'list'])
        ->name('github-accounts.list');

    Route::post('/github/accounts/{github_account_id}/delete', [GithubAccountController::class, 'delete'])
        ->name('github-accounts.delete');

    Route::get('/github/accounts/code', [GithubAccountController::class, 'code'])
        ->name('github-accounts.code');

    Route::get('/github/accounts/callback', [GithubAccountController::class, 'callback'])
        ->name('github-accounts.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/github/repositories/list', [GithubRepositoryController::class, 'list'])
        ->name('github-repositories.list');

    Route::post('/github/repositories/store', [GithubRepositoryController::class, 'store'])
        ->name('github-repositories.store');

    Route::post('/github/repositories/{github_repository_id}/delete', [GithubRepositoryController::class, 'delete'])
        ->name('github-repositories.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/brokers/list', [BrokerController::class, 'list'])
        ->name('brokers.list');

    Route::get('/brokers/{broker_id}/configure', [BrokerController::class, 'configure'])
        ->name('brokers.configure');

    Route::post('/brokers/{broker_id}/store', [BrokerController::class, 'store'])
        ->name('brokers.store');

    Route::post('/brokers/{broker_id}/delete', [BrokerController::class, 'delete'])
        ->name('brokers.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/projects/list', [ProjectController::class, 'list'])
        ->name('projects.list');

    Route::get('/projects/create', [ProjectController::class, 'create'])
        ->name('projects.create');

    Route::post('/projects/store', [ProjectController::class, 'store'])
        ->name('projects.store');

    Route::get('/projects/{project_id}/edit', [ProjectController::class, 'edit'])
        ->name('projects.edit');

    Route::post('/projects/{project_id}/update', [ProjectController::class, 'update'])
        ->name('projects.update');

    Route::get('/projects/{project_id}/detail', [ProjectController::class, 'detail'])
        ->name('projects.detail');

    Route::post('/projects/{project_id}/delete', [ProjectController::class, 'delete'])
        ->name('projects.delete');

    Route::post('/projects/{project_id}/status/toggle', [ProjectController::class, 'toggle_status'])
        ->name('projects.toggle-status');
});


Route::middleware('auth')->group(function () {
    Route::post('/algo-sessions/{algo_session_id}/secret/regenerate', [AlgoSessionController::class, 'regenerate_secret'])
        ->name('algo-sessions.regenerate-secret');
    
    Route::get('/algo-sessions/{algo_session_id}/overview', [AlgoSessionController::class, 'algo_session_overview'])
            ->name('algo-sessions.overview');
    
    Route::get('/algo-sessions/{algo_session_id}/orders', [AlgoSessionController::class, 'algo_session_orders'])
            ->name('algo-sessions.orders');

    Route::get('/algo-sessions/{algo_session_id}/positions', [AlgoSessionController::class, 'algo_session_positions'])
            ->name('algo-sessions.positions');
});

require __DIR__ . '/auth.php';
