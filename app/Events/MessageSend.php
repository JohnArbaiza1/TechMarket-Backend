<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ChatMessage $message)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        Log::info('Llegando al broadcastOn', [
            'id_user_one' => $this->message->id_user_one,
            'id_user_two' => $this->message->id_user_two,
        ]);
        $userOneId = min($this->message->id_user_one, $this->message->id_user_two);
        $userTwoId = max($this->message->id_user_one, $this->message->id_user_two);
        $channelName = 'chat.' . $userOneId . '-' . $userTwoId;

        return [
            new PrivateChannel($channelName),
        ];
    }
}
