<?php

namespace lewislarsen\LogcanyonLogger;

use Illuminate\Support\ServiceProvider;
use lewislarsen\LogcanyonLogger\Logging\CreateLogcanyonLogger;

class LogcanyonLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/logcanyon-logger.php', 'logcanyon-logger');

        $this->app->extend('log', function ($log, $app) {
            $log->extend('logcanyon', function ($app, $config) {
                return (new CreateLogcanyonLogger())($config);
            });
            return $log;
        });

        // Add the custom logger channel configuration
        $this->app->config['logging.channels.logcanyon'] = [
            'driver' => 'custom',
            'via' => CreateLogcanyonLogger::class,
            'level' => 'debug',
        ];
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/logcanyon-logger.php' => config_path('logcanyon-logger.php'),
        ], 'config');
    }
}
