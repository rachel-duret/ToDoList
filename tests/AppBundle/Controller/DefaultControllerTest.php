<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        //create http client 
        $this->client = static::createClient();
        /*  $this->userRepository = $this->client->getContainer()->get('doctrine')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('admin@mail.com');
        $urlGenerator = $this->client->getContainer()->get('router');
        $this->client->loginUser($this->user); */
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

    public function testHomepageIsLoginUser()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !", $this->client->getResponse()->getContent());
    }

    public function testHomepageUserNotLogin()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
