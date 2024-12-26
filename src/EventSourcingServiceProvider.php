<?php

namespace Webmaesther\EventSourcing;

use Illuminate\Foundation\Events\PublishingStubs;
use Illuminate\Support\ServiceProvider;
use Webmaesther\EventSourcing\Commands\AggregateMakeCommand;
use Webmaesther\EventSourcing\Commands\BuilderMakeCommand;
use Webmaesther\EventSourcing\Commands\ProjectionMakeCommand;
use Webmaesther\EventSourcing\Commands\ProjectorMakeCommand;
use Webmaesther\EventSourcing\Commands\SegregateMakeCommand;
use Webmaesther\EventSourcing\Listeners\PublishingStubsListener;
use Webmaesther\EventSourcing\Projection\Projectionist;
use Webmaesther\EventSourcing\Serializers\EventSerializer;

use function config_path;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../assets/config/event-sourcing.php', 'event-sourcing');

        $this->app->singleton(Projectionist::class);
        $this->app->singleton(EventBus::class);
        $this->app->bind(EventSerializer::class, config('event-sourcing.serializer'));
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../assets/config/' => config_path(),
        ], ['event-sourcing', 'config']);

        $this->publishesMigrations([
            __DIR__.'/../assets/database/migrations/' => database_path('migrations'),
        ], ['event-sourcing', 'migrations']);

        $this->commands([
            ProjectionMakeCommand::class,
            ProjectorMakeCommand::class,
            AggregateMakeCommand::class,
            SegregateMakeCommand::class,
            BuilderMakeCommand::class,
        ]);

        $this->app['events']->listen(PublishingStubs::class, PublishingStubsListener::class);
    }
}
