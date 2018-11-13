<?php

namespace Railken\Amethyst\Tests\Listeners;

use Illuminate\Queue\SerializesModels;

class DummyEvent
{
    use SerializesModels;

    /**
     * @var int
     */
    public $x;

    /**
     * @var Foo
     */
    public $foo;

    /**
     * Create a new event instance.
     *
     * @param int $x
     * @param Foo $foo
     */
    public function __construct(int $x, Foo $foo)
    {
        $this->x = $x;
        $this->foo = $foo;
    }
}
