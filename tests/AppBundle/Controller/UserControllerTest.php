<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends AbstractControllerTest
{
    public function testUserIndex()
    {
        $crawler = $this->client->request(Request::METHOD_GET, '/user');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('list user', $crawler->filter('h1')->text());
    }

    public function testUserCreate()
    {
        $crawler = $this->client->request(Request::METHOD_GET, '/user/create');

        $form = $crawler->filter('button')->form();

        $this->assertSame(Request::METHOD_POST, $form->getMethod());
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('form')->count());
    }

    public function testUserEdit()
    {
        $crawler = $this->client->request(Request::METHOD_PUT, '/user/1');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('form')->count());
    }

    public function testUserDeleteNotFound()
    {
        $this->client->request(Request::METHOD_DELETE, '/user/101');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }
}
