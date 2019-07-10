<?php

namespace Amethyst\Models;

use Amethyst\Common\ConfigurableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Railken\Lem\Contracts\EntityContract;

class EventLogAttribute extends Model implements EntityContract
{
    use ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.event-logger.data.event-log-attribute');
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event_log(): BelongsTo
    {
        return $this->belongsTo(config('amethyst.event-logger.data.event-log.model'));
    }
}
