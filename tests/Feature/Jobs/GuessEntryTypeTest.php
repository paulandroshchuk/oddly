<?php

it('processes failures correctly', function () {
    $entry = \App\Models\Entry::factory()
        ->forRandomUser()
        ->create();

    \OpenAI\Laravel\Facades\OpenAI::fake([
        \OpenAI\Responses\Completions\CreateResponse::fake([
            'choices' => [['text' => 'foo...']],
        ]),
    ]);

    $this->assertThrows(
        test: fn () => \App\Jobs\GuessEntryType::dispatch($entry),
        expectedMessage: 'is not a valid backing value',
    );

    $entry->refresh();

    $this->assertSame(\App\Enums\EntryType::UNKNOWN, $entry->type);
    $this->assertSame(\App\Enums\EntryStatus::FAILED, $entry->status);
});

it('guesses entry type', function () {
    $entry = \App\Models\Entry::factory()
        ->forRandomUser()
        ->create([
            'input' => 'apple',
        ]);

    \OpenAI\Laravel\Facades\OpenAI::fake([
        \OpenAI\Responses\Completions\CreateResponse::fake([
            'choices' => [['text' => 'WORD']],
        ]),
    ]);

    \App\Jobs\GuessEntryType::dispatch($entry);

    $entry->refresh();

    $this->assertSame(\App\Enums\EntryType::WORD, $entry->type);
    $this->assertSame(\App\Enums\EntryStatus::DONE, $entry->status);
});
