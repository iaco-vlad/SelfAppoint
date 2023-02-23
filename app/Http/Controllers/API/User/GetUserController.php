<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\MainController;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class GetUserController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'user' => null,
            'validationError' => null,
        ];
        try {
            $id = $args[0];
            $user = User::find($id);

            $response['user'] = $user->toArray();
            return response()->json($response);
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 403);
        }
    }
}
