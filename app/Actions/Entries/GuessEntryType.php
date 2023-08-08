<?php

namespace App\Actions\Entries;

use App\Enums\EntryType;
use App\Models\Entry;

class GuessEntryType
{
    public function __invoke(Entry $entry): EntryType
    {
        return EntryType::WORD;
    }
}
