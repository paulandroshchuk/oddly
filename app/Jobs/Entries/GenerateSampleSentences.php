<?php

namespace App\Jobs\Entries;

use App\Models\Entry;
use App\Prompts\EntryDescription;
use App\Prompts\EntrySampleSentence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateSampleSentences implements ShouldQueue
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
        $sentence = $this->getSampleSentence();
    }

    private function getSampleSentence(): string
    {
        return new EntrySampleSentence($this->entry);
    }
}
