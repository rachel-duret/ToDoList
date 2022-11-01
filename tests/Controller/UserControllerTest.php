<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
        $form['user[username]'] = 'username test';
        $form['user[password][first]'] = 'passwordtest';
        $form['user[password][second]'] = 'passwordtest';
        $form['user[email]'] = 'email@mail.com';


        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        // redirect to user list page
        $this->assertStringContainsString("L'utilisateur a bien été ajouté.",  $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString("username test",  $this->client->getResponse()->getStatusCode());
    }

    public function testUserEditAction()
    {
        // show the edit page
        $crawler = $this->client->request('GET', '/users/6/edit');

        /* **************
        Failed asserting that 500 matches expected 200. je ne sais pas pourquio
        *********************************8 */
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit user
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'admin update';
        $form['user[password][first]'] = 'passwordtest';
        $form['user[password][second]'] = 'passwordtest';
        $form['user[email]'] = 'admin@mail.com';
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        // redirect user list page
        $this->client->followRedirect();
        $this->assertContains(" L'utilisateur a bien été modifié", $this->client->getResponse()->getContent());
        $this->assertContains("username update", $this->client->getResponse()->getContent());
    }
}
