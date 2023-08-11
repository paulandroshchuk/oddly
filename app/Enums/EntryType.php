<?php

namespace App\Enums;

enum EntryType: string
{
    case WORD = 'WORD';
    case PHRASE = 'PHRASE';
    case UNKNOWN = 'UNKNOWN';
}
