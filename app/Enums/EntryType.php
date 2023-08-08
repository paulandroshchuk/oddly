<?php

namespace App\Enums;

enum EntryType: string
{
    case WORD = 'word'; // verb, adverb, etc
    case PHRASE = 'phrase';
    case UNKNOWN = 'unknown';
}
