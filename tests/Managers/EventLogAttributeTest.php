<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\EventLogAttributeFaker;
use Railken\Amethyst\Managers\EventLogAttributeManager;
use Railken\Amethyst\Tests\BaseTest;
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
