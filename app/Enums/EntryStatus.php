<?php

namespace App\Enums;

enum EntryStatus: string
{
    case PROCESSING = 'PROCESSING';
    case FAILED = 'FAILED';
    case PROCESSED = 'PROCESSED';

    public function isProcessing(): bool
    {
        return $this === self::PROCESSING;
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }

    public function isProcessed(): bool
    {
        return $this === self::PROCESSED;
    }
}
