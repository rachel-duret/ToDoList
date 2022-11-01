<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TaskControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        //create http client 
        $this->client = static::createClient();
        $this->repository = $this->client->getContainer()->get('doctrine')->getRepository(Task::class);
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

    public function testTaskPageUserNotLogin()
    {
        $this->client->request('GET', '/tasks');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testTaskListAction()
    {
        $this->repository->findAll();
        $this->logIn(['ROLE_USER']);
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("Supprimer", $this->client->getResponse()->getContent());
    }

    public function testTaskCreateAction()
    {
        // show the create page
        $this->logIn(['ROLE_USER']);
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // submit create form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = ' this is a title';
        $form['task[content]'] = 'content';


        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        // redirect to task list page
        $this->client->followRedirect();
        $this->assertContains("La tâche a été bien été ajoutée.", $this->client->getResponse()->getContent());
        $this->assertContains("this is a title", $this->client->getResponse()->getContent());
    }

    public function testTaskEditAction()
    {
        // show the edit page
        $this->logIn(['ROLE_USER']);
        $crawler = $this->client->request('GET', '/tasks/14/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit Task
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = ' update title';
        $form['task[content]'] = 'content';
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        // redirect task list page
        $this->client->followRedirect();
        $this->assertContains("La tâche a bien été modifiée.", $this->client->getResponse()->getContent());
        $this->assertContains("update title", $this->client->getResponse()->getContent());
    }

    public function testTaskToggleAction()
    {
        $this->logIn(['ROLE_USER']);
        $this->client->request('GET', '/tasks/14/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testTaskDeleteAction()
    {
        $this->logIn(['ROLE_USER']);
        // Id just can be test once
        $this->client->request('GET', 'tasks/10/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }
}
