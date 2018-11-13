<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class EventLogAttributeAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'event-log-attribute.create',
        Tokens::PERMISSION_UPDATE => 'event-log-attribute.update',
        Tokens::PERMISSION_SHOW   => 'event-log-attribute.show',
        Tokens::PERMISSION_REMOVE => 'event-log-attribute.remove',
    ];
}
