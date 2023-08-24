<?php

use App\Models\User;
use App\Jobs\GuessEntryType;
use Illuminate\Support\Facades\Bus;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    Bus::fake([
        GuessEntryType::class,
    ]);
});

it('throws 401 when guest creates entry', function () {
    $this->postJson('/api/entries', [
        'input' => 'comprehend',
    ])->assertUnauthorized();

    Bus::assertNothingDispatched();
});

it('requires input', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/entries')
        ->assertUnprocessable()
        ->assertInvalid([
            'input' => ['required'],
        ]);

    Bus::assertNothingDispatched();
});

it('creates an entry', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post('/api/entries', [
            'input' => 'comprehend',
        ])
        ->assertSuccessful()
        ->assertExactJson([
            'data' => [
                'input' => 'comprehend',
            ],
        ]);

    $this->assertCount(1, $user->entries()->get());

    $this->assertDatabaseHas('entries', [
        'user_id' => $user->getKey(),
        'input' => 'comprehend',
    ]);

    Bus::assertDispatched(
        fn (GuessEntryType $job) => $job->entry->input === 'comprehend',
    );
    Bus::assertDispatchedTimes(GuessEntryType::class, 1);
});

it('creates longer entry', function () {
    $user = User::factory()->create();
    $longerEntry = \Illuminate\Support\Str::random(300);

    actingAs($user)
        ->post('/api/entries', [
            'input' => $longerEntry,
        ])
        ->assertSuccessful()
        ->assertExactJson([
            'data' => [
                'input' => $longerEntry,
            ],
        ]);

    $this->assertSame($longerEntry, $user->entries()->first()->input);

    Bus::assertDispatched(
        fn (GuessEntryType $job) => $job->entry->input === $longerEntry,
    );
});
