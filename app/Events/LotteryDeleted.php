<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Lottery;

class LotteryDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lottery;

    /**
     * Create a new event instance.
     */
    public function __construct(Lottery $lottery)
    {
        $this->lottery = $lottery;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-lottery'),
        ];
    }
}
