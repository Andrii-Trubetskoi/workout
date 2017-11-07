<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    /** @var  Client */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }
}
