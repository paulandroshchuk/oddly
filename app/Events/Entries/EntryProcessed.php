<?php

namespace App\Events\Entries;

use App\Models\Entry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\SerializesModels;

class EntryProcessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    #[WithoutRelations]
    public Entry $entry;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('entries.'.$this->entry->getKey()),
        ];
    }

    public function broadcastAs(): string
    {
        return 'processed';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->entry->getKey(),
        ];
    }
}
