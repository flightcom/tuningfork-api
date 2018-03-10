<?php

namespace Managers\Notifications;

use PushNotification;

class NotificationsManager {
    public function sendEmail($content) {
        // Implement send email
    }

    public function sendPushNotificationToUser(
        $message,
        $user,
        $routeParams = [],
        $notificationType = 'standard'
    ) {
        if (count($user->devices)) {
            foreach ($user->devices as $device) {
                if ($device->push_notifications_active) {
                    $this->sendPushNotificationToDevice(
                        $message,
                        $device,
                        $routeParams,
                        $notificationType
                    );
                }
            }
        }
    }

    public function sendPushNotificationToDevice(
        $message,
        $device,
        $routeParams = [],
        $notificationType = 'standard'
    ) {
        if (
            $message
            && isset($device->token)
            && isset($device->type)
        ) {
            $pushNotificationContent = array(
                'badge' => 1,
                // IOs displays the 'locKey' on the notification ...
                'locKey' => $message,
                'custom' => $routeParams,
                'type' => $notificationType
            );

            // ... Android displays what is passed first in the Message object
            $message = PushNotification::Message(
                $message,
                $pushNotificationContent
            );

            $devices = PushNotification::DeviceCollection(array(
                PushNotification::Device(
                    $device->token
                ),
            ));

            if ($device->type === 'ios') {
                PushNotification::app(
                        env('PUSH_NOTIFICATION_IOS_APP_NAME', 'appNameIOS')
                    )
                    ->to($devices)
                    ->send($message);
            } else if ($device->type === 'android') {
                $collection = PushNotification::app(
                        env('PUSH_NOTIFICATION_ANDROID_APP_NAME', 'appNameAndroid')
                    )
                    ->to($devices);

                $collection
                    ->adapter
                    ->setAdapterParameters(array('sslverifypeer' => false));

                $collection->send($message);
            } else {
                \Log::warning('No device type recognized in ', [ 'user' => $device ]);
            }
        }
    }

}
