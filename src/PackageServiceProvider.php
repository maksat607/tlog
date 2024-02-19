<?php

namespace Maksatsaparbekov\Tlog;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/tlog-config.php' => config_path('tlog-config.php'),
        ], 'config');
        $this->mergeConfigFrom(__DIR__ . '/../config/tlog-config.php', 'tlog-config');

    }
}

