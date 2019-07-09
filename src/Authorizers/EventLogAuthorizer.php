<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class EventLogAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'event-log.create',
        Tokens::PERMISSION_UPDATE => 'event-log.update',
        Tokens::PERMISSION_SHOW   => 'event-log.show',
        Tokens::PERMISSION_REMOVE => 'event-log.remove',
    ];
}
