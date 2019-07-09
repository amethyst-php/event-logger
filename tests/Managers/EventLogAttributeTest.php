<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\EventLogAttributeFaker;
use Amethyst\Managers\EventLogAttributeManager;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class EventLogAttributeTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = EventLogAttributeManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = EventLogAttributeFaker::class;
}
