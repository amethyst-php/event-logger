<?php

namespace Railken\Amethyst\Tests\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'foo';
}
