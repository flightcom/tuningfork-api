<?php

namespace App\Http\Controllers\Notifications;

// Needed to dispatch a Job
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Utils\ApiValidator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Models\Device;
use NotificationsManager;

class NotificationsController extends Controller
{

    use DispatchesJobs;

    public function testEmailNotification(Request $request) {
        try {
            // send test Email

            return response()->json('ok', 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Test push notifications.
     *
     * @param string $type required, in ['email','ios','android']
     * @param text $token required if $type is 'ios' or 'android'
     * @return \Illuminate\Http\Response
     */
    public function testNotification(Request $request) {
        ApiValidator::make($request->all(), [
            'type' => 'required|in:ios,android',
            'token' => 'required',
            'job'   => 'sometimes'
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        if (!$request->job) {
            $device = new Device([
                'type' => $request->type,
                'token' => $request->token,
            ]);

            $pushNotificationResult = NotificationsManager::sendPushNotificationToDevice(
                'Salut Salut !',
                $device
            );

            return response()->json($pushNotificationResult, 200);
        } else {
            $this->dispatch(
                new \App\Jobs\PushNotifications\TestJob(
                    array(
                        'type' => $request->type,
                        'token' => $request->token,
                    )
                )
            );

            return response()->json('If your queue is setup correctly, you should get a push soon!', 200);
        }
    }
}
