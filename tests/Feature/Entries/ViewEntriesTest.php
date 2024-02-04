<?php

use App\Enums\EntryType;
use App\Models\Entry;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('throws 401 when guest reads entries', function () {
    $this->getJson('/api/entries')
        ->assertUnauthorized();
});

it('shows users entries', function () {
    $user = User::factory()->create();

    [$dog, $cat] = Entry::factory()
        ->for($user)
        ->forEachSequence(
            ['input' => 'dog', 'type' => EntryType::WORD_MEANING_IN_PHRASE],
            ['input' => 'cat', 'type' => EntryType::WORD_MEANING_IN_PHRASE],
        )
        ->create();

    actingAs($user)
        ->getJson('/api/entries')
        ->assertSuccessful()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('data.0.id', $cat->id)
        ->assertJsonPath('data.0.input', 'cat')
        ->assertJsonPath('data.0.type', 'WORD_MEANING_IN_PHRASE')
        ->assertJsonPath('data.1.id', $dog->id)
        ->assertJsonPath('data.1.input', 'dog')
        ->assertJsonPath('data.1.type', 'WORD_MEANING_IN_PHRASE');
});

it('shows entry meaning for WORD_MEANING_IN_PHRASE entries', function () {
    $user = User::factory()->create();

    $dog = Entry::factory()
        ->for($user)
        ->create([
            'input' => 'dog',
            'type' => EntryType::WORD_MEANING_IN_PHRASE,
            'meaning' => 'An animal.',
        ]);

    actingAs($user)
        ->getJson('/api/entries')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $dog->id)
        ->assertJsonPath('data.0.meta.meaning', 'An animal.');
});

it('shows only users entries', function () {
    [$paul, $jacob] = User::factory()
        ->count(2)
        ->create();

    Entry::factory()
        ->for($paul)
        ->create(['input' => 'pauls input', 'type' => EntryType::WORD_MEANING_IN_PHRASE]);

    Entry::factory()
        ->for($jacob)
        ->create(['input' => 'jacobs input', 'type' => EntryType::WORD_MEANING_IN_PHRASE]);

    actingAs($paul)
        ->getJson('/api/entries')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.input', 'pauls input');

    actingAs($jacob)
        ->getJson('/api/entries')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.input', 'jacobs input');
});
