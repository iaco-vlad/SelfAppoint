<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\MainController;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class CreateUserController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'user' => null,
            'validationError' => null
        ];
        try {
            $validatedData = request()->validate([
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'phone_number' => 'max:20',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|regex:/\d/',
            ]);

            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->title = $validatedData['title'];
            $user->phone_number = $validatedData['phone_number'];
            $user->password = bcrypt($validatedData['password']);
            $user->save();

            $user->sendEmailVerificationNotification();

            $response['user'] = $user;
            return response()->json($response, 201);
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 403);
        }
    }
}
