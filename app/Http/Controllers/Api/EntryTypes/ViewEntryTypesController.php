<?php

namespace App\Http\Controllers\Api\EntryTypes;

use App\Enums\EntryType;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ViewEntryTypesController extends Controller
{
    public function __invoke()
    {
        $groupedEntries = $this->getGroupedEntries();

        return response()->json([
            'data' => collect(EntryType::cases())
                ->map(fn (EntryType $entryType) => [
                    'type' => $entryType->value,
                    'title' => $entryType->title(),
                    'count' => $groupedEntries
                            ->firstWhere(fn (Entry $entry) => $entry->type === $entryType)
                            ?->count ?? 0,
                ])
                ->toArray(),
        ]);
    }

    protected function getGroupedEntries(): Collection
    {
        return auth()
            ->user()
            ->entries()
            ->groupBy('type')
            ->select('type')
            ->selectRaw('count(*) as count')
            ->get();
    }
}
