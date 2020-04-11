<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Browser;
use Illuminate\Http\Request;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Activity::saving(function (Activity $activity) {
            $activity->ip_address = \Request::ip();
            $activity->browser_name = Browser::browserName();
            $activity->os_name = Browser::platformName();
        });
    }
}
