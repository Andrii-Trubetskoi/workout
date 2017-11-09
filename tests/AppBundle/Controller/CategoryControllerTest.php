<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryControllerTest extends AbstractControllerTest
{
    public function testCategoryIndex()
    {
        $crawler = $this->client->request(Request::METHOD_GET, '/category');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('category list', $crawler->filter('h1')->text());
    }

    public function testCategoryCreate()
    {
        $crawler = $this->client->request(Request::METHOD_POST, '/category/create');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Have no content', $crawler->filter('h1')->text());
    }

    public function testCategoryEdit()
    {
        $crawler = $this->client->request(Request::METHOD_PUT, '/category/1');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Have no content', $crawler->filter('h1')->text());
    }

    public function testCategoryDeleteNotFound()
    {
        $this->client->request(Request::METHOD_DELETE, '/category/101');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }
}
