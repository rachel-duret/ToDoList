<?php

namespace App\Tests\Controller;

use App\Tests\Trait\LoginTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    use LoginTest;
    private $client = null;

    public function setUp(): void
    {
        //create http client 
        $this->client = static::createClient();
    }

    public function testHomepageIsLoginUser()
    {
        $this->getLoggedUser($this->client);
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !", $crawler->filter('h1')->text());
    }

    public function testHomepageUserNotLogin()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
