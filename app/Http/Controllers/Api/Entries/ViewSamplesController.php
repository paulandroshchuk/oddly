<?php

namespace App\Http\Controllers\Api\Entries;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Prompts\GetEntrySamples;

class ViewSamplesController extends Controller
{
    public function __invoke(Entry $entry)
    {
//        $this->authorize('view', $entry);

        return response()->json([
            'data' => [
//                (string) new GetEntrySamples($entry),
            ],
        ]);
    }
}
