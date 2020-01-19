<?php

namespace Amethyst\Models;

use Amethyst\Core\ConfigurableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Railken\Lem\Contracts\EntityContract;

class EventLog extends Model implements EntityContract
{
    use ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.event-logger.data.event-log');
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventAttributes(): HasMany
    {
        return $this->hasMany(config('amethyst.event-logger.data.event-log-attribute.model'));
    }
}
