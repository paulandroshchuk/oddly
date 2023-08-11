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
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $this->prompt(),
        ]);

        return trim($result['choices'][0]['text']);
    }

    abstract protected function prompt(): string;
}
