<?php

use App\Enums\EntryStatus;
use App\Enums\EntryType;
use App\Events\Entries\EntryProcessed;
use App\Jobs\Entries\GuessWordMeaningInPhrase;
use App\Models\Entry;
use Illuminate\Support\Facades\Event;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Completions\CreateResponse;

beforeEach(function () {
    Event::fake([
        EntryProcessed::class,
    ]);
});

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

it('marks entry as finished when job finishes', function () {
    $entry = Entry::factory()
        ->forRandomUser()
        ->create([
            'input' => 'apple',
            'status' => EntryStatus::PROCESSING,
            'type' => EntryType::WORD_MEANING_IN_PHRASE,
        ]);

    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [['text' => 'it describes color of the fruit']],
        ]),
    ]);

    GuessWordMeaningInPhrase::dispatchSync($entry);

    $this->assertTrue($entry->refresh()->status->isProcessed());
});

it('broadcasts EntryProcessed event when job processed', function () {
    $entry = Entry::factory()
        ->forRandomUser()
        ->create([
            'input' => 'apple',
            'status' => EntryStatus::PROCESSING,
            'type' => EntryType::WORD_MEANING_IN_PHRASE,
        ]);

    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [['text' => 'it describes color of the fruit']],
        ]),
    ]);

    GuessWordMeaningInPhrase::dispatchSync($entry);

    $this->assertTrue($entry->refresh()->status->isProcessed());

    Event::assertDispatched(
        fn (EntryProcessed $event) => $event->entry->is($entry),
    );
});

it('uses correct prompt to process WORD_MEANING_IN_PHRASE', function () {
    //
})->todo();
