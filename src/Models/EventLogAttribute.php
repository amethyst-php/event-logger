<?php

namespace Railken\Amethyst\Models;

use Illuminate\Database\Eloquent\Model;
use Railken\Amethyst\Common\ConfigurableModel;
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
    public function event_log()
    {
        return $this->belongsTo(EventLog::class);
    }
}
