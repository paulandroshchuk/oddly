<?php

namespace App\Prompts;

enum MessageRole: string
{
    case SYSTEM = 'SYSTEM';
    case USER = 'USER';

    public function role(): string
    {
        return str($this->value)->lower();
    }
}
