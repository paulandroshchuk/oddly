<?php

namespace App\Observers;

use App\Jobs\GuessEntryType;
use App\Models\Entry;

class EntryObserver
{
    public function created(Entry $entry): void
    {
        GuessEntryType::dispatch($entry);
    }
}
