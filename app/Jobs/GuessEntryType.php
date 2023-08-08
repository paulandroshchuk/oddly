<?php

namespace App\Jobs;

use App\Actions\Entries\GuessEntryType as EntryTypeGuesser;
use App\Enums\EntryStatus;
use App\Enums\EntryType;
use App\Models\Entry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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

    public function handle(EntryTypeGuesser $guessEntryType): void
    {
        $this->entry->type = $guessEntryType($this->entry);
        $this->entry->status = EntryStatus::DONE;
        $this->entry->save();
    }

    public function failed(): void
    {
        $this->entry->status = EntryStatus::FAILED;
        $this->entry->type = EntryType::UNKNOWN;
        $this->entry->save();
    }
}
