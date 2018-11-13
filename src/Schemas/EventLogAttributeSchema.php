<?php

namespace Railken\Amethyst\Schemas;

use Railken\Amethyst\Managers\EventLogManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class EventLogAttributeSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('name')
                ->setRequired(true),
            Attributes\TextAttribute::make('value')
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('event_log_id')
                ->setRelationName('event_log')
                ->setRelationManager(EventLogManager::class)
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
        ];
    }
}
