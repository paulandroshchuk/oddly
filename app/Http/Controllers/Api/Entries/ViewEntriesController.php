<?php

namespace App\Http\Controllers\Api\Entries;

use App\Enums\EntryType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EntryResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ViewEntriesController extends Controller
{
    public function __invoke()
    {
        $this->prepareType();

        $entries = QueryBuilder::for(auth()->user()->entries())
            ->allowedFilters([
                AllowedFilter::exact('type'),
            ])
            ->defaultSort('-id')
            ->cursorPaginate(10);

        return EntryResource::collection($entries);
    }

    private function prepareType(): void
    {
        if (! request()->has('filter.type')) {
            return;
        }

        $filter = request()->input('filter');
        $filter['type'] = collect(EntryType::cases())
            ->firstWhere(fn (EntryType $entryType) => $entryType->title() === $filter['type'])
            ?->value;

        request()->merge([
            'filter' => $filter,
        ]);
    }
}
