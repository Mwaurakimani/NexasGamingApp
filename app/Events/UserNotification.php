<?php

    namespace App\Events;

    use Illuminate\Support\Facades\Log;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Broadcasting\PrivateChannel;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

    class UserNotification implements ShouldBroadcastNow {
        use Dispatchable, SerializesModels;

        public int $toUserId;
        public string $message;
        public array $data;
        public string $created_at;

        public function __construct(int $toUserId, string $message, array $data = [])
        {
            $this->toUserId = $toUserId;
            $this->message = $message;
            $this->data = $data;
            $this->created_at = now()->toIso8601String();
        }

        public function broadcastOn(): PrivateChannel
        {
            return new PrivateChannel('user.' . $this->toUserId);
        }

        public function broadcastWith(): array
        {
            return [
                'id'         => uniqid(),
                'message'    => $this->message,
                'data'       => $this->data,
                'created_at' => $this->created_at,
            ];
        }

        public function broadcastAs(): string
        {
            return 'UserNotification';
        }
    }
