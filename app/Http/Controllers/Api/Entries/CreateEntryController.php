<?php

namespace App\Http\Controllers\Api\Entries;

use App\Enums\EntryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Entries\CreateEntryRequest;
use App\Http\Resources\Api\EntryResource;
use App\Jobs\GuessEntryType;
use App\Models\Entry;

class CreateEntryController extends Controller
{
    public function __invoke(CreateEntryRequest $request)
    {
        /** @var Entry $entry */
        $entry = $request->user()
            ->entries()
            ->create($request->safe()->all());

        GuessEntryType::dispatch($entry);

        return EntryResource::make($entry);
    }
}
