<?php

namespace App\Prompts;

use App\Models\Entry;

class GetEntrySamples extends Prompt
{
    readonly Entry $entry;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    #[Message(MessageRole::SYSTEM)]
    protected function setUpConversation(): string
    {
        return <<<SYSTEM
You are an English language expert. You will be provided an English word, you'll have to generate five different sentences using that word.

That should be different words and with basic English so learners can understand it.
SYSTEM;
    }

    #[Message(MessageRole::USER)]
    protected function askToGuessEntryType(): string
    {
        return <<<PROMPT
Here is the word:

{$this->entry->input}
PROMPT;
    }
}
