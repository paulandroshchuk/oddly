<?php

namespace App\Prompts;

use App\Models\Entry;

class GuessEntryType extends Prompt
{
    readonly Entry $entry;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    protected function prompt(): string
    {
        return <<<PROMPT
You are English teacher. What kind of type this text is?

Text: {$this->entry->input}

It can be only one of the following:
- WORD
- PHRASE
- UNKNOWN

Respond only with the word type. If you are not able to determine the type, respond with unknown.
PROMPT;
    }
}
