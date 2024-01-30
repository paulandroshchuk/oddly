<?php

namespace App\Prompts;

use App\Models\Entry;

class GuessWordMeaningInPhrase extends Prompt
{
    readonly Entry $entry;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    protected function prompt(): string
    {
        return <<<PROMPT
I'm learning English. You are English teacher. Help me understand the word meaning in the context.
I'll give you a word and its context. You should explain me the word meaning in the context.
Use simple, well known words so it will be easy for me to understand.

Word: {$this->entry->input}
Context: {$this->entry->context}

Respond only with the word meaning within its context.
If you're not able to determine the word meaning or that's not a valid message/context, respond with "".
PROMPT;
    }
}
