<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Controllers\API\MainController;
use App\Models\Service;
use Exception;
use Illuminate\Http\JsonResponse;

class GetServicesController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'validationError' => null,
            'services' => []
        ];
        try {
            if ($administratorId = request()->input('administrator_id')) {
                $response['services'] = Service::whereActive()->getAllByAdministratorId($administratorId);
                return response()->json($response);
            }
            if ($user = request()->user()) {
                $response['services'] = Service::getAllByAdministratorId($user->id);
                return response()->json($response);
            }
            $response['validationError'] = 'Not authorised';
            return response()->json($response, 403);
        } catch (Exception $e) {
            return response()->json($response, 500);
        }
    }
}
