<?php

namespace Railken\Amethyst\Tests\Listeners;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Railken\Amethyst\Managers\EventLogManager;
use Railken\Amethyst\Tests\BaseTest;

class BasicTest extends BaseTest
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        Schema::dropIfExists('foo');
        Schema::create('foo', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function testEloquentEvents()
    {
        config(['amethyst.event-logger.models-loggable' => [Foo::class]]);
        $foo = Foo::create();

        $log = (new EventLogManager())->getRepository()->findOneBy(['name' => 'eloquent.created: '.get_class($foo)]);
        $this->assertEquals(1, $log->id);
        $this->assertEquals($foo->id, $log->eventAttributes->where('name', 'foo_id')->first()->value);

        $foo->id = 2;
        $foo->save();

        $log = (new EventLogManager())->getRepository()->findOneBy(['name' => 'eloquent.updated: '.get_class($foo)]);
        $this->assertEquals(2, $log->id);
        $this->assertEquals($foo->id, $log->eventAttributes->where('name', 'foo_id')->first()->value);

        $foo->delete();

        $log = (new EventLogManager())->getRepository()->findOneBy(['name' => 'eloquent.deleted: '.get_class($foo)]);
        $this->assertEquals(3, $log->id);
        $this->assertEquals($foo->id, $log->eventAttributes->where('name', 'foo_id')->first()->value);
    }

    public function testEvents()
    {
        config(['amethyst.event-logger.events-loggable' => [DummyEvent::class]]);

        event(new DummyEvent(7, $foo = Foo::create()));

        $log = (new EventLogManager())->getRepository()->findOneBy(['name' => DummyEvent::class]);

        $this->assertEquals(1, $log->id);
        $this->assertEquals(7, $log->eventAttributes->where('name', 'x')->first()->value);
        $this->assertEquals($foo->id, $log->eventAttributes->where('name', 'foo_id')->first()->value);
    }
}
