<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\MainController;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class SendVerificationEmailController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'validationError' => null,
        ];

        try {
            $validatedData = request()->validate([
                'email' => 'required|email',
            ]);

            if (
                ($user = User::where('email', $validatedData['email'])->first())
                && !$user->hasVerifiedEmail()
            ) {
                $user->sendEmailVerificationNotification();
                return response()->json($response);
            }

            $response['validationError'] = 'Either the user does not exist or it has already been verified.';
            return response()->json($response, 403);
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 401);
        }
    }
}
