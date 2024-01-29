<?php

namespace App\Enums;

enum EntryType: string
{
    case WORD_MEANING_IN_PHRASE = 'WORD_MEANING_IN_PHRASE';
    case UNKNOWN = 'UNKNOWN';

    public function wordMeaningInPhrase(): bool
    {
        return $this === self::WORD_MEANING_IN_PHRASE;
    }
}
