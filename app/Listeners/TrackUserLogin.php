<?php

    namespace App\Listeners;

    use Laravel\Reverb\Loggers\Log;
    use Illuminate\Auth\Events\Login;
    use Illuminate\Support\Facades\Redis;
    use App\Events\AdminUserLoginNotification;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Queue\InteractsWithQueue;

    class TrackUserLogin {
        /**
         * Create the event listener.
         */
        public function __construct()
        {
            //
        }

        /**
         * Handle the event.
         */
        public function handle(Login $event): void
        {
            Redis::hset('online_users', $event->user->id, json_encode([
                                                                          'id'        => $event->user->id,
                                                                          'name'      => $event->user->username,
                                                                          'last_seen' => now()->timestamp,
                                                                      ]));

            event(new AdminUserLoginNotification($event->user));
        }
    }
