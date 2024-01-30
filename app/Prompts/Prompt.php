<?php

namespace App\Prompts;

use OpenAI\Laravel\Facades\OpenAI;

abstract class Prompt
{
    protected string $completion;

    public function __toString(): string
    {
        return $this->completion ??= $this->promptResult();
    }

    protected function promptResult(): string
    {
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                'role' => 'user', 'content' => $this->prompt(),
            ],
        ]);

        return trim($result->choices[0]->message->content);
    }

    abstract protected function prompt(): string;
}
