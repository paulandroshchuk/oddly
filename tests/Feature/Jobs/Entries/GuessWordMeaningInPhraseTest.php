<?php

use App\Enums\EntryStatus;
use App\Enums\EntryType;
use App\Jobs\Entries\GuessWordMeaningInPhrase;
use App\Models\Entry;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Completions\CreateResponse;

it('guesses word meaning in phrase', function () {
    $entry = Entry::factory()
        ->forRandomUser()
        ->create([
            'input' => 'apple',
            'context' => 'the apple is green',
            'status' => EntryStatus::PROCESSING,
            'type' => EntryType::WORD_MEANING_IN_PHRASE,
        ]);

    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [['text' => 'it describes color of the fruit']],
        ]),
    ]);

    GuessWordMeaningInPhrase::dispatchSync($entry);

    $this->assertSame('it describes color of the fruit', $entry->refresh()->meaning);
});

it('marks entry as failed when job fails', function () {
    $entry = Entry::factory()
        ->forRandomUser()
        ->create([
            'input' => 'apple',
            'status' => EntryStatus::PROCESSING,
            'type' => EntryType::WORD_MEANING_IN_PHRASE,
        ]);

    $this->assertTrue($entry->status->isProcessing());

    (new GuessWordMeaningInPhrase($entry))->failed();

    $this->assertTrue($entry->fresh()->status->isFailed());
});

it('throws exception when entry context is null', function () {
    //
})->todo();

it('marks entry as finished when job finishes', function () {
    //
})->todo();

it('broadcastes entry finished event when job finishes', function () {
    //
})->todo();
