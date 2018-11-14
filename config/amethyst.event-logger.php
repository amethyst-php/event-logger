<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components.
    |
    */
    'data' => [
        'event-log' => [
            'table'      => 'amethyst_event_logs',
            'comment'    => 'Event Log',
            'model'      => Railken\Amethyst\Models\EventLog::class,
            'schema'     => Railken\Amethyst\Schemas\EventLogSchema::class,
            'repository' => Railken\Amethyst\Repositories\EventLogRepository::class,
            'serializer' => Railken\Amethyst\Serializers\EventLogSerializer::class,
            'validator'  => Railken\Amethyst\Validators\EventLogValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\EventLogAuthorizer::class,
            'faker'      => Railken\Amethyst\Fakers\EventLogFaker::class,
            'manager'    => Railken\Amethyst\Managers\EventLogManager::class,
        ],
        'event-log-attribute' => [
            'table'      => 'amethyst_event_log_attributes',
            'comment'    => 'Event Log Attribute',
            'model'      => Railken\Amethyst\Models\EventLogAttribute::class,
            'schema'     => Railken\Amethyst\Schemas\EventLogAttributeSchema::class,
            'repository' => Railken\Amethyst\Repositories\EventLogAttributeRepository::class,
            'serializer' => Railken\Amethyst\Serializers\EventLogAttributeSerializer::class,
            'validator'  => Railken\Amethyst\Validators\EventLogAttributeValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\EventLogAttributeAuthorizer::class,
            'faker'      => Railken\Amethyst\Fakers\EventLogAttributeFaker::class,
            'manager'    => Railken\Amethyst\Managers\EventLogAttributeManager::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'http' => [
        'admin' => [
            'event-log' => [
                'enabled'     => true,
                'controller'  => Railken\Amethyst\Http\Controllers\Admin\EventLogsController::class,
                'router'      => [
                    'as'        => 'event-log.',
                    'prefix'    => '/event-logs',
                ],
            ],
            'event-log-attribute' => [
                'enabled'     => true,
                'controller'  => Railken\Amethyst\Http\Controllers\Admin\EventLogAttributesController::class,
                'router'      => [
                    'as'        => 'event-log-attribute.',
                    'prefix'    => '/event-log-attributes',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Models Loggable
    |--------------------------------------------------------------------------
    |
    | An array of classes that indicates which model event should be logged
    | You can use either the class of the model or an interface
    |
    */
    'models-loggable' => [
        // App\Models\DummyModel::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Events Loggable
    |--------------------------------------------------------------------------
    |
    | An array of classes that indicates which events should be logged
    | You can use either the class of the model or an interface
    |
    */
    'events-loggable' => [
        // App\Events\DummyEvent::class,
    ],
];
