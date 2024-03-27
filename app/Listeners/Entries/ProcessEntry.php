<?php

namespace App\Listeners\Entries;

use App\Enums\EntryType;
use App\Events\Entries\EntryTypeDetected;
use App\Jobs\Entries\ComeUpWithWordDescription;
use App\Models\Entry;

class ProcessEntry
{
    public function handle(EntryTypeDetected $event): void
    {
        match ($event->entry->type) {
            EntryType::WORD => $this->processWord($event->entry),
            default => null,
        };
    }

    private function processWord(Entry $entry): void
    {
        ComeUpWithWordDescription::dispatch($entry);
    }
}
