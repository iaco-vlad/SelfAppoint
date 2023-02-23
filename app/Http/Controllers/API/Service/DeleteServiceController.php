<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Controllers\API\MainController;
use App\Models\Service;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteServiceController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'validationError' => null
        ];
        try {
            if ($user = request()->user()) {
                Service::where('administrator_id', $user->id)->where('id', $args[0])->delete();
                return response()->json($response);
            } else {
                $response['validationError'] = 'Not authorised';
                return response()->json($response, 403);
            }
        } catch (Exception $e) {
            return response()->json($response, 500);
        }
    }
}
