<?php

namespace App\Http\Controllers\API\Event;

use App\Http\Controllers\API\MainController;
use App\Models\Event;
use Exception;
use Illuminate\Http\JsonResponse;

class GetEventsController extends MainController
{
    public function execute(...$args): JsonResponse
    {
        $response = [
            'events' => null,
            'validationError' => null,
        ];
        try {
            if ($user = request()->user()) {
                $events = Event::getAllByUserId($user->id);
                $curatedEvents = $events->toArray();
                foreach ($events as $key => $event) {
                    $curatedEvents[$key]['user_name'] = $event->user?->name;
                    $curatedEvents[$key]['service_name'] = $event->service?->name;
                    $curatedEvents[$key]['service_timespan'] = $event->service?->timespan;
                }
                $response['events'] = $curatedEvents;
                return response()->json($response);
            }
            $response['validationError'] = 'Not authorised';
            return response()->json($response, 403);
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
}
