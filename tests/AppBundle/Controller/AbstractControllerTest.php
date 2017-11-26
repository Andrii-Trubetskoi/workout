<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractControllerTest extends WebTestCase
{
    /** @var  Client */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        static::runCommand($this->client->getKernel(), ['command' => 'l:t:f', '-e' => 'test', '-f' => true]);
    }


    /**
     * @param KernelInterface $kernel
     * @param array           $arguments
     */
    public static function runCommand(KernelInterface $kernel, array $arguments = [])
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput($arguments);
        $output = new BufferedOutput();
        $application->run($input, $output);
    }
}
