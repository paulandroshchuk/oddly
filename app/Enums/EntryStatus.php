<?php

namespace App\Enums;

enum EntryStatus: string
{
    case PROCESSING = 'PROCESSING';
    case FAILED = 'FAILED';
    case DONE = 'DONE';
}
