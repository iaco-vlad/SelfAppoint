<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Controllers\API\MainMiddlewareController;
use App\Models\Service;
use Exception;
use Illuminate\Http\JsonResponse;

class UpdateServiceController extends MainMiddlewareController
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

                $service = Service::where('administrator_id', $user->id)
                    ->where('id', $args[0])
                    ->update($validatedData);
                $response['service'] = $service;

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
