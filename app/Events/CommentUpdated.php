<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $pendingCommentsCount;

    /**
     * Create a new event instance.
     */
    public function __construct($pendingCommentsCount)
    {
        $this->pendingCommentsCount = $pendingCommentsCount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('comments'),
    //     ];
    // }
    public function broadcastOn()
    {
        return new Channel('comments');
    }
}
