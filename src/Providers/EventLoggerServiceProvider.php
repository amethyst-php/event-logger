<?php

namespace Railken\Amethyst\Providers;

use Doctrine\Common\Inflector\Inflector;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Managers\EventLogAttributeManager;
use Railken\Amethyst\Managers\EventLogManager;
use Illuminate\Support\Arr;
use Railken\Amethyst\Api\Support\Router;

class EventLoggerServiceProvider extends CommonServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable(Config::get('amethyst.event-logger.data.event-log.table'))) {
            Event::listen(['eloquent.updated: *', 'eloquent.created: *', 'eloquent.deleted: *'], function ($event_name, $events) {
                // E.g. eloquent.created: Railken\Amethyst\Tests\Listeners\Foo
                [$event, $class] = explode(': ', $event_name);
                [$eloquent, $event] = explode('.', $event);
                $model = $events[0];

                $loggable = Collection::make(Config::get('amethyst.event-logger.models-loggable'))->filter(function ($class) use ($model) {
                    return get_class($model) === $class || $model instanceof $class;
                })->count();

                if ($loggable === 0) {
                    return;
                }

                $inflector = new Inflector();

                (new EventLogAttributeManager())->createOrFail([
                    'event_log' => [
                        'name' => $event_name,
                    ],
                    'name'  => $inflector->singularize($model->getTable()).'_id',
                    'value' => $model->id,
                ]);
            });

            Event::listen(['*'], function ($event_name, $events) {
                $event = $events[0];

                $loggable = Collection::make(Config::get('amethyst.event-logger.events-loggable'))->filter(function ($class) use ($event) {
                    return get_class($event) === $class || $event instanceof $class;
                })->count();

                if ($loggable === 0) {
                    return;
                }

                $inflector = new Inflector();

                $eventLog = (new EventLogManager())->create(['name' => $event_name])->getResource();

                $properties = (new \ReflectionClass($event))->getProperties();
                foreach ($properties as $property) {
                    $name = $property->getName();

                    if ($event->$name instanceof QueueableEntity) {
                        $params = [
                            'name'  => $inflector->singularize($event->$name->getTable()).'_id',
                            'value' => $event->$name->id,
                        ];
                    } else {
                        $params = [
                            'name'  => $name,
                            'value' => $event->$name,
                        ];
                    }

                    (new EventLogAttributeManager())->create(array_merge($params, ['event_log_id' => $eventLog->id]));
                }
            });
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();
        $this->loadExtraRoutes();
    }

    /**
     * Load extras routes.
     */
    public function loadExtraRoutes()
    {
        $config = Config::get('amethyst.event-logger.http.admin.event-log');
        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');
                $router->get('/stats', ['as' => 'stats', 'uses' => $controller.'@stats']);
            });
        }
    }
}
