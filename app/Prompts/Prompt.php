<?php

namespace App\Prompts;

use Illuminate\Support\Arr;
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
            'model' => 'gpt-4',
            'messages' => $this->getMessages(),
        ]);

        return trim($result->choices[0]->message->content);
    }

    protected function getMessages(): array
    {
        return collect((new \ReflectionClass($this))->getMethods())
            ->map(function (\ReflectionMethod $method) {
                $attribute = Arr::first($method->getAttributes(Message::class));

                if (blank($attribute)) {
                    return null;
                }

                return [
                    'role' => $attribute->getArguments()[0]->role(),
                    'content' => $method->invoke($this),
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }
}
