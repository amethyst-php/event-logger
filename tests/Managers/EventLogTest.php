<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\EventLogFaker;
use Railken\Amethyst\Managers\EventLogManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class EventLogTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = EventLogManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = EventLogFaker::class;
}
