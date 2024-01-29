<?php

namespace App\Http\Requests\Api\Entries;

use Illuminate\Foundation\Http\FormRequest;

class CreateEntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'input' => [
                'required',
                'string',
            ],
        ];
    }
}
