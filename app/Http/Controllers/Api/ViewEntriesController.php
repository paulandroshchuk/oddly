<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EntryResource;

class ViewEntriesController extends Controller
{
    public function __invoke()
    {
        $entries = auth()
            ->user()
            ->entries()
            ->latest('id')
            ->get();

        return EntryResource::collection($entries);
    }
}
