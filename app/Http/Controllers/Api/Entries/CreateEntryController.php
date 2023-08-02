<?php

namespace App\Http\Controllers\Api\Entries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Entries\CreateEntryRequest;
use App\Http\Resources\Api\EntryResource;
use Illuminate\Http\Request;

class CreateEntryController extends Controller
{
    public function __invoke(CreateEntryRequest $request)
    {
        $entry = $request->user()
            ->entries()
            ->create($request->safe()->all());

        return EntryResource::make($entry);
    }
}
