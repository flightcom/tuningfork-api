<?php

namespace App\Jobs\PushNotifications;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Models\User;

use NotificationsManager;
use DB;

class ReportChatInvitation extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        $job,
        $data
    ) {
        $inviter = User::find($data['inviterId']);
        $invitee =  User::find($data['inviteeId']);

        if($invitee && isset($invitee->device_localization)) {
            (substr($invitee->device_localization, 0, 2) === 'en')
                ? \App::setLocale('en')
                : \App::setLocale('fr');

            $displayMessage = $inviter->first_name . ' ' . $inviter->last_name
                . trans('pushNotifications.invitedToChat');

            NotificationsManager::sendPushNotification(
                $displayMessage,
                $invitee,
                [
                    'route' => 'chat',
                    'params' => [
                        'discussionId' => $data['discussionId'],
                        'participants' => $data['participants'],
                        'discussionType' => $data['discussionType']
                    ]
                ],
                'chatInvitation'
            );
        }

        $this->delete();
        $job->delete();
    }
}
