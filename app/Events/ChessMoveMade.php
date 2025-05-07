<?php

    namespace App\Events;

    use Illuminate\Broadcasting\PrivateChannel;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

    class ChessMoveMade implements ShouldBroadcastNow
    {
        use Dispatchable,SerializesModels;

        public array $move;
        public string $matchId;

        public function __construct(array $move, string $matchId)
        {
            $this->move = $move;
            $this->matchId = $matchId;
        }

        public function broadcastOn(): PrivateChannel
        {
            return new PrivateChannel('chess.match.' . $this->matchId);
        }

        public function broadcastWith(): array
        {
            return [
                'move' => $this->move,
            ];
        }

        public function broadcastAs(): string
        {
            return 'ChessMoveMade';
        }
    }
