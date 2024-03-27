<?php

namespace App\Events\Entries;

use App\Models\Entry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EntryTypeDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Entry $entry;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }
}
