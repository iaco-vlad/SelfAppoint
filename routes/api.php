<?php

use App\Http\Controllers\API\Event\CreateEventController;
use App\Http\Controllers\API\Event\DeleteEventController;
use App\Http\Controllers\API\Event\GetEventController;
use App\Http\Controllers\API\Event\UpdateEventController;
use App\Http\Controllers\API\Service\CreateServiceController;
use App\Http\Controllers\API\Service\DeleteServiceController;
use App\Http\Controllers\API\Service\GetServiceController;
use App\Http\Controllers\API\Service\UpdateServiceController;
use App\Http\Controllers\API\User\CreateUserController;
use App\Http\Controllers\API\User\GetUserController;
use App\Http\Controllers\API\User\LoginController;
use App\Http\Controllers\API\User\UpdateUserController;
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


Route::prefix('api')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [LoginController::class, 'execute']);
    });

    Route::prefix('user')->group(function () {
        Route::post('/', [CreateUserController::class, 'execute']);

        Route::post('{id}', [UpdateUserController::class, 'execute']);

        Route::get('{id}', [GetUserController::class, 'execute']);
    });

    Route::prefix('service')->group(function () {
        Route::post('/', [CreateServiceController::class, 'execute']);

        Route::post('{id}', [UpdateServiceController::class, 'execute']);

        Route::get('{id}', [GetServiceController::class, 'execute']);

        Route::delete('{id}', [DeleteServiceController::class, 'execute']);
    });

    Route::prefix('event')->group(function () {
        Route::post('/', [CreateEventController::class, 'execute']);

        Route::post('{id}', [UpdateEventController::class, 'execute']);

        Route::get('{id}', [GetEventController::class, 'execute']);

        Route::delete('{id}', [DeleteEventController::class, 'execute']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
