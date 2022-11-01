<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        //create http client 
        $this->client = static::createClient();
    }

    private function logIn(array $role)
    {
        $session = $this->client->getContainer()->get('session');
        $firewallName = 'main';
        $firewallContext = 'main';
        $token = new UsernamePasswordToken('user', null, $firewallName, $role);

        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testUserPageUserNotLogin()
    {
        $this->client->request('GET', '/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testUserListAction()
    {
        $this->logIn(['ROLE_USER']);
        $crawler = $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("Liste des utilisateurs", $this->client->getResponse()->getContent());
        $this->assertContains("#", $crawler->filter('th')->text());
    }

    public function testUserCreateAction()
    {
        // show the create page
        $this->logIn(['ROLE_USER']);
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
        $this->client->followRedirect();
        $this->assertContains("L'utilisateur a bien été ajouté.", $this->client->getResponse()->getContent());
        $this->assertContains("username test", $this->client->getResponse()->getContent());
    }

    public function testUserEditAction()
    {
        // show the edit page
        $this->logIn(['ROLE_USER']);
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
