<?php

namespace lewislarsen\LogcanyonLogger\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use lewislarsen\LogcanyonLogger\LogcanyonLoggerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'lewislarsen\\LogcanyonLogger\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LogcanyonLoggerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_logcanyon-logger_table.php.stub';
        $migration->up();
        */
    }
}
