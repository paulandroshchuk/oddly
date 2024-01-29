<?php

namespace App\Enums;

enum EntryStatus: string
{
    case PROCESSING = 'PROCESSING';
    case FAILED = 'FAILED';
    case DONE = 'DONE';

    public function isProcessing(): bool
    {
        return $this === self::PROCESSING;
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }
}
