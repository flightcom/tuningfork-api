<?php

namespace App\Jobs\PushNotifications;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Models\User;

use NotificationsManager;
use DB;

class TestJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $token;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->token    = $data['token'];
        $this->type     = $data['type'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        if ($this->token && $this->type) {
            NotificationsManager::sendPushNotification(
                'Yo, this is a Push notifications sent by a Job!',
                new User([
                    'device_type' => $this->type,
                    'device_token' => $this->token,
                    'push_notifications_active' => 1
                ]),
                [],
                'testNotification'
            );
        }
    }
}
