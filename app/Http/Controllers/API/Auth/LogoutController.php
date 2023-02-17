<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\MainController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends MainController
{

    public function execute(...$args): JsonResponse
    {
        $response = [
            'validationError' => null,
        ];
        try {
            $user = Auth::user();
            $user?->tokens()->delete();

            return response()->json($response);
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
}
