<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\EventLog newEntity()
 * @method \Amethyst\Schemas\EventLogSchema getSchema()
 * @method \Amethyst\Repositories\EventLogRepository getRepository()
 * @method \Amethyst\Serializers\EventLogSerializer getSerializer()
 * @method \Amethyst\Validators\EventLogValidator getValidator()
 * @method \Amethyst\Authorizers\EventLogAuthorizer getAuthorizer()
 */
class EventLogManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.event-logger.data.event-log';
}
