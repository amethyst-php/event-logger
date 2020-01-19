<?php

namespace Amethyst\Managers;

use Amethyst\Core\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\EventLogAttribute                 newEntity()
 * @method \Amethyst\Schemas\EventLogAttributeSchema          getSchema()
 * @method \Amethyst\Repositories\EventLogAttributeRepository getRepository()
 * @method \Amethyst\Serializers\EventLogAttributeSerializer  getSerializer()
 * @method \Amethyst\Validators\EventLogAttributeValidator    getValidator()
 * @method \Amethyst\Authorizers\EventLogAttributeAuthorizer  getAuthorizer()
 */
class EventLogAttributeManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.event-logger.data.event-log-attribute';
}
