<?php

namespace App\Jobs\Entries;

use App\Enums\EntryStatus;
use App\Enums\EntryType;
use App\Events\Entries\EntryTypeDetected;
use App\Models\Entry;
use App\Prompts\GuessEntryType as EntryTypePrompt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GuessEntryType implements ShouldQueue
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
        $this->entry->type = EntryType::from(new EntryTypePrompt($this->entry));
        $this->entry->status = EntryStatus::PROCESSED;
        $this->entry->save();

        EntryTypeDetected::dispatch($this->entry);
    }

    public function failed(): void
    {
        $this->entry->status = EntryStatus::FAILED;
        $this->entry->type = EntryType::OTHER;
        $this->entry->save();

        EntryTypeDetected::dispatch($this->entry);
    }
}
