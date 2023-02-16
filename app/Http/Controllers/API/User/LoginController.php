<?php

namespace App\Http\Controllers\API\User;

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
            $credentials = request()->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
        } catch (ValidationException $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 401);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $response['user'] = $user->toArray();
            $response['token'] = $user->createToken(session_id())->plainTextToken;
            return response()->json($response);
        } else {
            $response['validationError'] = 'Invalid email or password.';
            return response()->json($response, 401);
        }
    }
}
