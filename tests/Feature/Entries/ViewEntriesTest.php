<?php

use App\Models\Entry;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('throws 401 when guest reads entries', function () {
    $this->getJson('/api/entries')
        ->assertUnauthorized();
});

it('shows users entries', function () {
    $user = User::factory()->create();

    Entry::factory()
        ->for($user)
        ->forEachSequence(
            ['input' => 'order entry'],
            ['input' => 'earlier entry'],
        )
        ->create();

    actingAs($user)
        ->getJson('/api/entries')
        ->assertSuccessful()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('data.0.input', 'earlier entry')
        ->assertJsonPath('data.1.input', 'order entry');
});

it('shows only users entries', function () {
    [$paul, $jacob] = User::factory()
        ->count(2)
        ->create();

    Entry::factory()
        ->for($paul)
        ->create(['input' => 'pauls input']);

    Entry::factory()
        ->for($jacob)
        ->create(['input' => 'jacobs input']);

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
