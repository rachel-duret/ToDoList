<?php

namespace App\Tests\Controller;

use App\DataFixtures\UserFixture;
use App\Entity\User;
use App\Tests\Trait\LoginTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    use LoginTest;
    private $client = null;

    public function setUp(): void
    {
        //create http client 
        $this->client = static::createClient();
    }


    public function testUserPageUserNotLogin()
    {
        $this->client->request('GET', '/users');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserCreatePageLoggedUserNotAdmin()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine')->getRepository(User::class);

        $this->user = $this->userRepository->findOneByEmail('username@mail.com');

        $this->client->loginUser($this->user);

        $this->client->request('GET', '/users/create');
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert.alert-danger', 'page not found .');
    }


    public function testUserEditPageLoggedUserNotAdmin()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine')->getRepository(User::class);

        $this->user = $this->userRepository->findOneByEmail('username@mail.com');

        $this->client->loginUser($this->user);

        $this->client->request('GET', '/users/17/edit');
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert.alert-danger', 'page not found .');
    }

    public function testUserListAction()
    {
        $this->getLoggedUser($this->client);

        $crawler = $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Liste des utilisateurs", $this->client->getResponse()->getContent());
        $this->assertStringContainsString("#", $crawler->filter('th')->text());
    }

    public function testUserCreateAction()
    {
        // show the create page
        $this->getLoggedUser($this->client);
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // submit create form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'username1 test';
        $form['user[password][first]'] = 'passwordtest';
        $form['user[password][second]'] = 'passwordtest';
        $form['user[email]'] = 'username1test@mail.com';
        $form['user[roles]'] = ["ROLE_USER"];


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
        $this->getLoggedUser($this->client);
        $crawler = $this->client->request('GET', '/users/17/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit user
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'username up';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'username@mail.com';
        $form['user[roles]'] = ["ROLE_USER"];
        $this->client->submit($form);
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-success", "L'utilisateur a bien été modifié");

        // redirect to user list page
        $this->assertSelectorTextContains("table", "username up");
    }
}
