<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Controllers\API\MainController;
use App\Models\Service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetServicesController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'services' => []
        ];
        try {
            if ($user = Auth::user()) {
                $response['services'] = Service::getAllByAdministratorId($user->id);
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
