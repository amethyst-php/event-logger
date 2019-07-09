<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\EventLogFaker;
use Amethyst\Managers\EventLogManager;
use Amethyst\Tests\BaseTest;
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
