<?php

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V3\TransactionController;
use App\Http\Controllers\Api\V3\UserController;
use App\Http\Middleware\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
    Route::get('status', [StatusController::class, 'index'])->withoutMiddleware('api');
});

Route::group(['prefix' => 'v3', 'namespace' => 'Api\V3'], function () {
    Route::group(['prefix' => 'merchant'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::post('login', [UserController::class, 'authenticate'])->withoutMiddleware('api');
        });
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::post('report', [TransactionController::class, 'report']);
    });
    
    Route::group(['prefix' => 'transaction'], function () {
        Route::post('/', [TransactionController::class, 'detail']);
        Route::post('list', [TransactionController::class, 'list']);
    });
    
    Route::group(['prefix' => 'client'], function () {
        Route::post('/', [TransactionController::class, 'client']);
    });
});