<?php

namespace App\Http\Controllers\API\Event;

use App\Helpers\Enums\EventStatusEnum;
use App\Http\Controllers\API\MainController;
use App\Models\Event;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UpdateEventStatusController extends MainController
{
    private const NO_ACCESS_MESSAGE = 'You do not have access to this assets.';
    private const INCORRECT_TIMESPAN = 'You cannot use this status at this moment.';

    public function execute(...$args): JsonResponse
    {
        $response = [
            'validationError' => null,
        ];

        try {
            if (!Auth::check()) {
                throw new Exception(self::NO_ACCESS_MESSAGE);
            }

            $this->updateEventStatus($args[0]);

            return response()->json($response);
        } catch (Exception $e) {
            $response['validationError'] = $e->getMessage();
            return response()->json($response, 403);
        }
    }

    /**
     * @param $statusId
     * @return void
     * @throws Exception
     */
    private function updateEventStatus($statusId): void
    {
        $validatedData = request()->validate([
            'status' => 'required|in:' . $this->getFormattedStatusArrayForValidator(),
        ]);

        $status = $validatedData['status'];
        $event = Event::findOrFail($statusId);
        $this->validateStatus($status, $event);

        $event->status = $status;
        $event->save();
    }

    /**
     * @param string $status
     * @param Event $event
     * @return void
     * @throws Exception
     */
    private function validateStatus(string $status, Event $event): void
    {
        $loggedUserId = request()->user()->id;

        switch ($status) {
            case EventStatusEnum::CONFIRMED:
            case EventStatusEnum::DECLINED:
                if ($loggedUserId !== $event->administrator_id) {
                    throw new Exception(self::NO_ACCESS_MESSAGE);
                }
                if ($event->isInThePast) {
                    throw new Exception(self::INCORRECT_TIMESPAN);
                }
                // TODO: Send nofication email to the user.
//                User::find($event->user_id)->;
                break;
            case EventStatusEnum::CANCELED:
                if ($loggedUserId !== $event->user_id) {
                    throw new Exception(self::NO_ACCESS_MESSAGE);
                }
                if ($event->isInThePast) {
                    throw new Exception(self::INCORRECT_TIMESPAN);
                }
                break;
            case EventStatusEnum::HONORED:
            case EventStatusEnum::UNHONORED:
                if ($loggedUserId !== $event->administrator_id) {
                    throw new Exception(self::NO_ACCESS_MESSAGE);
                }
                if (!$event->isInThePast) {
                    throw new Exception(self::INCORRECT_TIMESPAN);
                }
                break;
            default:
                throw new Exception('Unexpected status value.');
        }
    }

    /**
     * @return string
     */
    private function getFormattedStatusArrayForValidator(): string
    {
        return implode(',', EventStatusEnum::getMap());
    }
}
