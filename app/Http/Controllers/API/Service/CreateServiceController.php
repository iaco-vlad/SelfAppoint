<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Controllers\API\MainController;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Models\Service;

class CreateServiceController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'service' => null,
            'validationError' => null,
        ];

        try {
            if ($user = request()->user()) {
                $validatedData = request()->validate([
                    'name' => 'required|string|max:255',
                    'timespan' => 'required|integer',
                    'is_active' => 'boolean',
                    'show_timespan' => 'boolean',
                ]);
                $validatedData['administrator_id'] = $user->id;

                $service = Service::create($validatedData);
                $response['service'] = $service->toArray();

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
