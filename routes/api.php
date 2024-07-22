<?php

use App\Http\Controllers\AlgoSessionController;
use App\Http\Controllers\BaseSymbolController;
use App\Http\Controllers\BrokerSymbolController;
use App\Http\Controllers\GithubAccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TradingCalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/algo-sessions/info', [AlgoSessionController::class, 'get_info'])
    ->name('algo-sessions.info');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/holidays/list', [TradingCalendarController::class, "get_holidays"]);

    Route::get('/trading-days/list', [TradingCalendarController::class, "get_trading_days"]);

    Route::get("/github/accounts/{github_account_id}/access-token", [GithubAccountController::class, "get_access_token"]);

    Route::get("/base-symbols/list", [BaseSymbolController::class, "get_base_symbols"]);

    Route::get('/broker-symbols/{broker_title}/info', [BrokerSymbolController::class, "get_symbol_info"]);

    Route::post('/broker-symbols/{broker_title}/info', [BrokerSymbolController::class, "add_symbol_info"]);
});

Route::group(['prefix' => 'algo-sessions/{algo_session_key}', 'middleware' => 'auth:sanctum'], function () {
    Route::get("/orders/list", [OrderController::class, "get_orders"]);
    Route::post("/orders/create", [OrderController::class, "create_order"]);

    Route::get("/positions/list", [PositionController::class, "get_positions"]);
    Route::post("/positions/enter", [PositionController::class, "enter_position"]);
    Route::post("/positions/exit", [PositionController::class, "exit_position"]);

    Route::get("/trades/list", [PositionController::class, "get_trades"]);
});
