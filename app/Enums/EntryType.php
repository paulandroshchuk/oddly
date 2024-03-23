<?php

namespace App\Enums;

enum EntryType: string
{
    case WORD = 'WORD';
    case CLAUSE = 'CLAUSE';
    case PHRASE = 'PHRASE';
    case SENTENCE = 'SENTENCE';
    case TEXT = 'TEXT';
    case OTHER = 'OTHER';

    public function title(): string
    {
        if ($this === self::OTHER) {
            return 'Other';
        }

        return str($this->value)
            ->title()
            ->plural();
    }
}
