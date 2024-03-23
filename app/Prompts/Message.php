<?php

namespace App\Prompts;

use Attribute;

#[Attribute]
class Message
{
    public readonly MessageRole $messageRole;

    public function __constuct(MessageRole $messageRole)
    {
        $this->messageRole = $messageRole;
    }
}
