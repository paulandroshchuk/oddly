<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;

class EntryPolicy
{
    public function view(User $user, Entry $entry): bool
    {
        return $entry->user()->is($user);
    }
}
