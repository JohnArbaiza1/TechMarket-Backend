<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSend implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ChatMessage $message)
    {
        Log::info('📢 Evento MessageSend disparado', ['mensaje' => $this->message->toArray()]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
       
        $userOneId = max($this->message->id_user_one, $this->message->id_user_two);
        $userTwoId = min($this->message->id_user_one, $this->message->id_user_two);
        $channelName = 'chat.' . $userOneId . '-' . $userTwoId;
        Log::info('Llegando al broadcastOn', [
            'id_user_one' => $this->message->id_user_one,
            'id_user_two' => $this->message->id_user_two,
            'canal' => $channelName,
        ]);
        
        return [
            new PrivateChannel($channelName),
        ];
    }
    public function broadcastAs(): string
    {
        return 'MessageSend';
    }
}
