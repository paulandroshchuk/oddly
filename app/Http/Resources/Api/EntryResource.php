<?php

namespace App\Http\Resources\Api;

use App\Enums\EntryType;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

/**
 * @mixin Entry
 */
class EntryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'type' => $this->type,
            'input' => $this->input,
            'description' => $this->description,
        ];
    }
}
