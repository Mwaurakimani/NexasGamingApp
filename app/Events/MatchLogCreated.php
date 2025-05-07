<?php

    namespace App\Events;

    use App\Models\MatchLog;
    use App\Models\Matches;
    use Illuminate\Broadcasting\PrivateChannel;
    use Illuminate\Broadcasting\InteractsWithSockets;
    use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Queue\SerializesModels;

    class MatchLogCreated implements ShouldBroadcast
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;

        public Matches $match;
        public MatchLog $log;

        /**
         * Create a new event instance.
         */
        public function __construct(Matches $match, MatchLog $log)
        {
            $this->match = $match;
            $this->log   = $log;
        }

        /**
         * The channel the event should broadcast on.
         */
        public function broadcastOn(): PrivateChannel
        {
            return new PrivateChannel('match.' . $this->match->id);
        }

        /**
         * The data to broadcast.
         */
        public function broadcastWith(): array
        {
            return [
                'id'         => $this->log->id,
                'match_id'   => $this->log->match_id,
                'user_id'    => $this->log->user_id,
                'type'       => $this->log->type,
                'content'    => $this->log->content,
                'created_at' => $this->log->created_at->toIso8601String(),
            ];
        }
    }
