<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\MainController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UpdateUserController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'user' => null,
            'validationError' => null,
        ];
        try {
            if ($user = Auth::user()) {
                $validatedData = array_filter(request()->validate([
                    'name' => 'string|max:255',
                    'title' => 'string|max:255',
                    'phone_number' => 'max:20',
                    'password' => 'nullable|string|min:8|regex:/\d/',
                ]));
                if (isset($validatedData['password'])) {
                    if ($user->email === 'randomemailname@vlad-iacovenco.com') { // For testing purposes only.
                        $response['validationError'] = "You cannot change the password of the sample user.";
                        return response()->json($response, 403);
                    }
                    $validatedData['password'] = bcrypt($validatedData['password']);
                }

                $user->update($validatedData);
                $response['user'] = $user;

                return response()->json($response);
            } else {
                $response['validationError'] = 'Not authorised';
                return response()->json($response, 403);
            }
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 403);
        }
    }
}
