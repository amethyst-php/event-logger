<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Managers\EventLogManager;
use Railken\Amethyst\Managers\EventLogAttributeManager;
use Illuminate\Support\Collection;
use Doctrine\Common\Inflector\Inflector;

class EventLoggerServiceProvider extends CommonServiceProvider
{  
	/**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable(Config::get('amethyst.event-logger.data.event-log.table'))) {
 
        	Event::listen(['eloquent.updated: *', 'eloquent.created: *', 'eloquent.deleted: *'], function($event_name, $events) {

    			// E.g. eloquent.created: Railken\Amethyst\Tests\Listeners\Foo
    			[$event, $class] = explode(": ", $event_name);
    			[$eloquent, $event] = explode(".", $event);
    			$model = $events[0];


    			$loggable = Collection::make(Config::get('amethyst.event-logger.models-logged'))->filter(function($class) use ($model) {
    				return get_class($model) === $class || $model instanceof $class;
    			})->count();

    			if ($loggable === 0) {
    				return false;
    			}

    			$inflector = new Inflector();

    			(new EventLogAttributeManager())->createOrFail([
    				'event_log' => [
    					'name' => $event_name
    				], 
    				'name' => $inflector->singularize($model->getTable()).'_id', 
    				'value' => $model->id
    			]);
            });
        }
    }

}
