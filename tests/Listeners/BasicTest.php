<?php

namespace Railken\Amethyst\Tests\Listeners;

use Railken\Amethyst\Fakers\EventLogFaker;
use Railken\Amethyst\Managers\EventLogManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

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

    public function testModelCreatedLogged()
    {
        config(['amethyst.event-logger.models-logged' => [Foo::class]]);
        $foo = Foo::create();

        $log = (new EventLogManager())->getRepository()->findOneBy(['name' => "eloquent.created: ".get_class($foo)]);
        $this->assertEquals(1, $log->id);
        $this->assertEquals($foo->id, $log->eventAttributes->where('name', 'foo_id')->first()->value);

        $foo->id = 2;
        $foo->save();

        $log = (new EventLogManager())->getRepository()->findOneBy(['name' => "eloquent.updated: ".get_class($foo)]);
        $this->assertEquals(2, $log->id);
        $this->assertEquals($foo->id, $log->eventAttributes->where('name', 'foo_id')->first()->value);

        $foo->delete();

        $log = (new EventLogManager())->getRepository()->findOneBy(['name' => "eloquent.deleted: ".get_class($foo)]);
        $this->assertEquals(3, $log->id);
        $this->assertEquals($foo->id, $log->eventAttributes->where('name', 'foo_id')->first()->value);
    }
}
