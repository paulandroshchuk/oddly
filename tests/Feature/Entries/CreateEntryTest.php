<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

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
});
