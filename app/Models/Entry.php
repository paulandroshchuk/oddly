<?php

namespace App\Models;

use App\Enums\EntryStatus;
use App\Enums\EntryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => EntryStatus::class,
        'type' => EntryType::class,
    ];

    protected $attributes = [
        'status' => EntryStatus::PROCESSING,
    ];

    public function user()
    {
        return $this->belongsTo(Entry::class);
    }

    public function result()
    {
        return $this->morphTo();
    }

    public function setFailed(): void
    {
        $this->status = EntryStatus::FAILED;
    }

    public function setProcessed(): void
    {
        $this->status = EntryStatus::PROCESSED;
    }
}
