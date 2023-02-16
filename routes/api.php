<?php

use App\Http\Controllers\API\Event\CreateEventController;
use App\Http\Controllers\API\Event\DeleteEventController;
use App\Http\Controllers\API\Event\GetEventController;
use App\Http\Controllers\API\Event\UpdateEventController;
use App\Http\Controllers\API\Service\CreateServiceController;
use App\Http\Controllers\API\Service\DeleteServiceController;
use App\Http\Controllers\API\Service\GetServiceController;
use App\Http\Controllers\API\Service\GetServicesController;
use App\Http\Controllers\API\Service\UpdateServiceController;
use App\Http\Controllers\API\User\CreateUserController;
use App\Http\Controllers\API\User\GetUserController;
use App\Http\Controllers\API\User\LoginController;
use App\Http\Controllers\API\User\UpdateUserController;
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

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'execute'])->name('login');

    Route::post('signup', [CreateUserController::class, 'execute']);
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('users')->group(function () {
        Route::put('{id}', [UpdateUserController::class, 'execute']);

        Route::get('{id}', [GetUserController::class, 'execute']);
    });

    Route::prefix('services')->group(function () {
        Route::post('/', [CreateServiceController::class, 'execute']);

        Route::get('/', [GetServicesController::class, 'execute']);

        Route::put('{id}', [UpdateServiceController::class, 'execute']);

        Route::get('{id}', [GetServiceController::class, 'execute']);

        Route::delete('{id}', [DeleteServiceController::class, 'execute']);
    });

    Route::prefix('events')->group(function () {
        Route::post('/', [CreateEventController::class, 'execute']);

        Route::put('{id}', [UpdateEventController::class, 'execute']);

        Route::get('{id}', [GetEventController::class, 'execute']);

        Route::delete('{id}', [DeleteEventController::class, 'execute']);
    });
});
