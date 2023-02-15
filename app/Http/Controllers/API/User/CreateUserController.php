<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\MainController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateUserController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $request = new Request;
        $user = new User;

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        $user->save();
    }
}
