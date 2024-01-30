<?php

namespace App\Jobs\Entries;

use App\Enums\EntryStatus;
use App\Events\Entries\EntryProcessed;
use App\Models\Entry;
use App\Prompts\GuessWordMeaningInPhrase as GuessWordMeaningInPhrasePrompt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GuessWordMeaningInPhrase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    #[WithoutRelations]
    public Entry $entry;

    public int $maxExceptions = 3;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function handle(): void
    {
        $this->entry->meaning = new GuessWordMeaningInPhrasePrompt($this->entry);
        $this->entry->setProcessed();
        $this->entry->save();

        EntryProcessed::dispatch($this->entry);
    }

    public function failed(): void
    {
        $this->entry->setFailed();
        $this->entry->save();
    }
}
