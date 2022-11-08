<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp(): void
    {
        //create http client 
        $this->client = static::createClient();
    }


    public function testUserPageUserNotLogin()
    {
        $this->client->request('GET', '/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testUserListAction()
    {

        $crawler = $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Liste des utilisateurs", $this->client->getResponse()->getContent());
        $this->assertStringContainsString("#", $crawler->filter('th')->text());
    }

    public function testUserCreateAction()
    {
        // show the create page

        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // submit create form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'username1 test';
        $form['user[password][first]'] = 'passwordtest';
        $form['user[password][second]'] = 'passwordtest';
        $form['user[email]'] = 'username1test@mail.com';


        $this->client->submit($form);
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-success", "L'utilisateur a bien été ajouté.");

        // redirect to user list page
        $this->assertSelectorTextContains("table", "username1 test");
    }

    public function testUserEditAction()
    {
        // show the edit page
        $crawler = $this->client->request('GET', '/users/18/edit');

        /* **************
        Failed asserting that 500 matches expected 200. je ne sais pas pourquio
        *********************************8 */
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit user
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'username0test';
        $form['user[password][first]'] = 'passwordtest';
        $form['user[password][second]'] = 'passwordtest';
        $form['user[email]'] = 'username0test@mail.com';
        $this->client->submit($form);
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-success", " L'utilisateur a bien été modifié");

        // redirect to user list page
        $this->assertSelectorTextContains("table", "username0test");
    }
}
