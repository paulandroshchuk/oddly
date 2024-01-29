<?php

namespace App\Http\Requests\Api\Entries;

use App\Enums\EntryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'input' => [
                'required',
                'string',
                'max:100',
            ],
            'type' => [
                'required',
                Rule::enum(EntryType::class),
            ],
            'context' => Rule::when($this->type()?->wordMeaningInPhrase(), [
                'required',
                'string',
                'max:3000',
            ]),
        ];
    }

    protected function type(): ?EntryType
    {
        return $this->enum('type', EntryType::class);
    }
}
