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
            'model'      => Amethyst\Models\EventLog::class,
            'schema'     => Amethyst\Schemas\EventLogSchema::class,
            'repository' => Amethyst\Repositories\EventLogRepository::class,
            'serializer' => Amethyst\Serializers\EventLogSerializer::class,
            'validator'  => Amethyst\Validators\EventLogValidator::class,
            'authorizer' => Amethyst\Authorizers\EventLogAuthorizer::class,
            'faker'      => Amethyst\Fakers\EventLogFaker::class,
            'manager'    => Amethyst\Managers\EventLogManager::class,
        ],
        'event-log-attribute' => [
            'table'      => 'amethyst_event_log_attributes',
            'comment'    => 'Event Log Attribute',
            'model'      => Amethyst\Models\EventLogAttribute::class,
            'schema'     => Amethyst\Schemas\EventLogAttributeSchema::class,
            'repository' => Amethyst\Repositories\EventLogAttributeRepository::class,
            'serializer' => Amethyst\Serializers\EventLogAttributeSerializer::class,
            'validator'  => Amethyst\Validators\EventLogAttributeValidator::class,
            'authorizer' => Amethyst\Authorizers\EventLogAttributeAuthorizer::class,
            'faker'      => Amethyst\Fakers\EventLogAttributeFaker::class,
            'manager'    => Amethyst\Managers\EventLogAttributeManager::class,
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
