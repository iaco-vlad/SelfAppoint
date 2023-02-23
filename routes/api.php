<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\SendVerificationEmailController;
use App\Http\Controllers\API\Event\CreateEventController;
use App\Http\Controllers\API\Event\GetEventsController;
use App\Http\Controllers\API\Event\UpdateEventStatusController;
use App\Http\Controllers\API\Service\CreateServiceController;
use App\Http\Controllers\API\Service\DeleteServiceController;
use App\Http\Controllers\API\Service\GetServicesController;
use App\Http\Controllers\API\Service\UpdateServiceController;
use App\Http\Controllers\API\User\CreateUserController;
use App\Http\Controllers\API\User\GetUserController;
use App\Http\Controllers\API\User\UpdateUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'execute'])->name('login');

    Route::post('logout', [LogoutController::class, 'execute'])->name('logout');

    Route::post('signup', [CreateUserController::class, 'execute']);

    Route::post('send-verification-email', [SendVerificationEmailController::class, 'execute']);
});

Route::prefix('events')->group(function () {
    Route::post('/', [CreateEventController::class, 'execute']);
});

Route::prefix('users')->group(function () {
    Route::get('{id}', [GetUserController::class, 'execute']);
});

// Private routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('users')->group(function () {
        Route::put('{id}', [UpdateUserController::class, 'execute']);
    });

    Route::prefix('services')->group(function () {
        Route::post('/', [CreateServiceController::class, 'execute']);

        Route::get('/', [GetServicesController::class, 'execute']);

        Route::put('{id}', [UpdateServiceController::class, 'execute']);

        Route::delete('{id}', [DeleteServiceController::class, 'execute']);
    });

    Route::prefix('events')->group(function () {
        Route::get('/', [GetEventsController::class, 'execute']);

        Route::patch('{id}/update-status', [UpdateEventStatusController::class, 'execute']);
    });
});

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
