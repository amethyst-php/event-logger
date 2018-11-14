<?php

namespace Railken\Amethyst\Tests\Http\Admin;

use Railken\Amethyst\Api\Support\Testing\TestableBaseTrait;
use Railken\Amethyst\Fakers\EventLogFaker;
use Railken\Amethyst\Managers\EventLogManager;
use Railken\Amethyst\Tests\BaseTest;
use Symfony\Component\HttpFoundation\Response;

class EventLogTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = EventLogFaker::class;

    /**
     * Router group resource.
     *
     * @var string
     */
    protected $group = 'admin';

    /**
     * Route name.
     *
     * @var string
     */
    protected $route = 'admin.event-log';

    /**
     * Test stats
     */
    public function testHttpStats()
    {
        (new EventLogManager())->createOrFail(EventLogFaker::make()->parameters());

        $response = $this->callAndTest('GET', route($this->getRoute().'.stats'), [], Response::HTTP_OK);
    }
}
