<?php

namespace App\Http\Controllers\API\Event;

use App\Helpers\Enums\EventStatusEnum;
use App\Http\Controllers\API\MainController;
use App\Models\Event;
use App\Models\Service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CreateEventController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'event' => null,
            'validationError' => null,
        ];

        try {
            $validatedData = request()->validate([
                'administrator_id' => 'integer',
                'service_id' => 'required|integer',
                'date' => ['required', 'date_format:Y-m-d'],
                'time' => ['required', 'date_format:H:i'],
                'description' => 'nullable|string',
            ]);

            if ($user = Auth::user()) {
                $validatedData['user_id'] = $user->id;
            }
            if (!isset($validatedData['administrator_id'])) {
                $validatedData['administrator_id'] = null;
            }
            $validatedData['status'] = EventStatusEnum::PENDING;

            $event = Event::create($validatedData);
            $response['event'] = $event->toArray();
            return response()->json($response, 201);
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 403);
        }
    }
}
