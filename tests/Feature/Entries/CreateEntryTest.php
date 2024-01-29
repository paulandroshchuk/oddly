<?php

use App\Enums\EntryType;
use App\Jobs\Entries\GuessWordMeaningInPhrase;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    Bus::fake();
});

it('throws 401 when guest creates entry', function () {
    $this->postJson('/api/entries', [
        'input' => 'comprehend',
    ])->assertUnauthorized();
});

it('requires input', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/entries')
        ->assertUnprocessable()
        ->assertInvalid([
            'input' => ['required'],
        ]);
});

it('requires type', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/entries')
        ->assertUnprocessable()
        ->assertInvalid([
            'type' => ['required'],
        ]);
});

it('asserts type to be valid', function () {
    actingAs(User::factory()->create())
        ->postJson('/api/entries', [
            'input' => 'something',
            'type' => 'invalid'
        ])
        ->assertUnprocessable()
        ->assertInvalid([
            'type' => 'The selected type is invalid.',
        ]);
});

it('requires context when type is WORD_MEANING_IN_PHRASE', function () {
    actingAs(User::factory()->create())
        ->postJson('/api/entries', [
            'input' => 'something',
            'type' => EntryType::WORD_MEANING_IN_PHRASE->value,
        ])
        ->assertUnprocessable()
        ->assertInvalid([
            'context' => ['required'],
        ]);
});

it('cannot create a WORD_MEANING_IN_PHRASE with entry longer than 100 characters long', function () {
    actingAs(User::factory()->create())
        ->postJson('/api/entries', [
            'input' => Str::random(101),
            'type' => EntryType::WORD_MEANING_IN_PHRASE->value,
        ])
        ->assertUnprocessable()
        ->assertInvalid([
            'input' => 'The input field must not be greater than 100 characters.',
        ]);
});

it('creates an entry with type WORD_MEANING_IN_PHRASE', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post('/api/entries', [
            'input' => 'comprehend',
            'type' => EntryType::WORD_MEANING_IN_PHRASE->value,
            'context' => 'foo',
        ])
        ->assertSuccessful()
        ->assertExactJson([
            'data' => [
                'id' => ($entry = $user->entries()->sole())->getKey(),
                'type' => EntryType::WORD_MEANING_IN_PHRASE,
                'input' => 'comprehend',
            ],
        ]);

    $this->assertDatabaseHas('entries', [
        'id' => $entry->getKey(),
        'user_id' => $user->getKey(),
        'input' => 'comprehend',
    ]);

    Bus::assertDispatched(
        fn (GuessWordMeaningInPhrase $job) => $job->entry->is($entry) && $job->entry->context === 'foo',
    );
    Bus::assertDispatchedTimes(GuessWordMeaningInPhrase::class, 1);
});

