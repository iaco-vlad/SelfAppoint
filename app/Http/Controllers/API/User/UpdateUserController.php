<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\MainMiddlewareController;
use Exception;
use Illuminate\Http\JsonResponse;

class UpdateUserController extends MainMiddlewareController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'user' => null,
            'validationError' => null,
        ];
        try {
            if ($user = request()->user()) {
                $validatedData = array_filter(request()->validate([
                    'name' => 'string|max:255',
                    'title' => 'string|max:255',
                    'phone_number' => 'max:20',
                    'password' => 'nullable|string|min:8|regex:/\d/',
                ]));
                if (isset($validatedData['password'])) {
                    // FOR TESTING PURPOSES ONLY
                    if ($user->email === 'randomemailname@self-appoint.vlad-iacovenco.com') {
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
