<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\MainController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $id = $args[0];
        $user = User::find($id);

        $responseData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phoneNumber' => $user->phone_number,
            'isAdmin' => $user->is_admin,
        ];

        return response()->json($responseData);
    }
}
