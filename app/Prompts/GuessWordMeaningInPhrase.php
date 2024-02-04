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

    protected function fooPrompt(): string
    {
        /*
         * Random thoughts:
         * I think we'll need to define the sentence type first. And then, based on it, we should come up with a prompt.
         *
         * For instance, when it has two objects, it should be one prompt. For other sentences - other prompts, etc.
         */

        return <<<PROMPT
Imagine you've come across the word "Benevolent". Using context clues and possibly an online dictionary, define "benevolent". Then, write a short story featuring a character who exhibits benevolent behavior. How does their benevolence play out in the story? What consequences does it have for other characters?
PROMPT;

    }
}
