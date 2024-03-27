<?php

namespace App\Jobs\Entries;

use App\Models\Entry;
use App\Prompts\EntryDescription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComeUpWithWordDescription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Entry $entry;

    public int $maxExceptions = 3;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function handle(): void
    {
        $this->entry->description = new EntryDescription($this->entry);
        $this->entry->save();
    }

    public function failed(): void
    {
        $this->entry->description = 'Failed to load description...';
        $this->entry->save();
    }
}
