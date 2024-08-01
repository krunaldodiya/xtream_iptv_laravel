<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlanSubscriptionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ChataiController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function () {
    return 'test';
});

Route::middleware('auth')->group(function () {
    Route::get('/chatai', [ChataiController::class, 'home'])->name('chatai.home');
    Route::post('/chatai', [ChataiController::class, 'store'])->name('chatai.store');
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

Route::get('/stream/{stream_id}', [ChannelController::class, 'stream']);

require __DIR__ . '/auth.php';
