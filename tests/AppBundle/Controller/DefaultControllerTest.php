<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Kernel;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        //create http client 
        $this->client = static::createClient();
    }

    public function testHomepageAnonymousUser()
    {
        $crawler = $this->client->request('GET', '/');
        $this->

    }
    public function testHomepageIsUp()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !", $this->client->getResponse()->getContent());
    }
}
