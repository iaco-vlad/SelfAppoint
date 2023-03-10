<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\MainController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'validationError' => null,
            'user' => null,
            'token' => null,
        ];

        try {
            $validatedData = request()->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            if (Auth::attempt($validatedData)) {
                $user = request()->user();
                if (!$user->hasVerifiedEmail()) {
                    $response['validationError'] = 'Confirm your account from your email before using the app.';
                    return response()->json($response, 403);
                }

                $response['user'] = $user->toArray();
                $response['token'] = $user->createToken('api_token')->plainTextToken;
                return response()->json($response);
            } else {
                $response['validationError'] = 'Invalid email or password.';
                return response()->json($response, 403);
            }
        } catch (ValidationException $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 401);
        }
    }
}
