<?php

namespace Amethyst\Providers;

use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Core\Support\Router;
use Amethyst\Managers\EventLogAttributeManager;
use Amethyst\Managers\EventLogManager;
use Doctrine\Common\Inflector\Inflector;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;

class EventLoggerServiceProvider extends CommonServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        return;

        if (Schema::hasTable(Config::get('amethyst.event-logger.data.event-log.table'))) {
            Event::listen(['eloquent.updated: *', 'eloquent.created: *', 'eloquent.deleted: *'], function ($event_name, $events) {
                // E.g. eloquent.created: Amethyst\Tests\Listeners\Foo
                [$event, $class] = explode(': ', $event_name);
                [$eloquent, $event] = explode('.', $event);
                $model = $events[0];

                $loggable = Collection::make(Config::get('amethyst.event-logger.models-loggable'))->filter(function ($class) use ($model) {
                    return is_object($model) && get_class($model) === $class || $model instanceof $class;
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
                if (!isset($events[0])) {
                    return;
                }

                $event = $events[0];

                $loggable = Collection::make(Config::get('amethyst.event-logger.events-loggable'))->filter(function ($class) use ($event) {
                    return is_object($event) && get_class($event) === $class || $event instanceof $class;
                })->count();

                if ($loggable === 0) {
                    return;
                }

                $inflector = new Inflector();

                $eventLog = (new EventLogManager())->create(['name' => $event_name])->getResource();

                $properties = (new \ReflectionClass($event))->getProperties();
                foreach ($properties as $property) {
                    $name = $property->getName();
                    $value = $event->$name;
                    $params = [];

                    if ($value instanceof QueueableEntity) {
                        $params = [
                            'name'  => $inflector->singularize($value->getTable()).'_id',
                            'value' => $value->id,
                        ];
                    } elseif (method_exists($value, '__toString') || is_scalar($value)) {
                        $params = [
                            'name'  => $name,
                            'value' => $value,
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
