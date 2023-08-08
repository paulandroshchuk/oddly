<?php

it('processes failures correctly', function () {
    $entry = \App\Models\Entry::factory()
        ->forRandomUser()
        ->create();

    $this->mock(\App\Actions\Entries\GuessEntryType::class)
        ->shouldReceive('__invoke')
        ->andThrow(new Exception('Something went wrong'));

    $this->assertThrows(
        test: fn () => \App\Jobs\GuessEntryType::dispatch($entry),
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

    \App\Jobs\GuessEntryType::dispatch($entry);

    $entry->refresh();

    $this->assertSame(\App\Enums\EntryType::WORD, $entry->type);
    $this->assertSame(\App\Enums\EntryStatus::DONE, $entry->status);
});
