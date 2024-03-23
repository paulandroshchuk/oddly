<?php

namespace App\Http\Controllers\Api\Entries;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EntryResource;
use App\Models\Entry;

class ViewEntryController extends Controller
{
    public function __invoke(Entry $entry)
    {
//        $this->authorize('view', $entry);

        return EntryResource::make($entry);
    }
}
