<?php

namespace App\Providers;

use App\Models\Entry;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->setUpDefaultSettings();
    }

    private function setUpDefaultSettings(): void
    {
        MorphTo::morphMap([
            'entries' => Entry::class,
        ]);

        Model::preventLazyLoading(! app()->isProduction());

        Http::preventStrayRequests();

        DB::whenQueryingForLongerThan(
            threshold: CarbonInterval::seconds(1),
            handler: function (Connection $connection, QueryExecuted $query) {
                report('Slow query detected: '.$query->sql);
            },
        );
    }
}
