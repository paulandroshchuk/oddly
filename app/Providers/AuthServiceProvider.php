<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Entry;
use App\Policies\EntryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Entry::class => EntryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function ($user) {
            return in_array($user->email, [
                'impaul@hey.com',
            ]);
        });
    }
}
