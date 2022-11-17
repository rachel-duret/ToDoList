<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp(): void
    {
        //create http client 
        $this->client = static::createClient();
    }
    public function testloginActionWithCorrectCredentials()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit Task
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'admin';
        $form['_password'] = 'password';


        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("a.pull-right.btn.btn-danger", "Se déconnecter");
    }

    public function testloginActionWithBadCredentials()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit Task
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'admin';
        $form['_password'] = 'passwordnotgood';


        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-danger", "Invalid credentials");
    }
}
