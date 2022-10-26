<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
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
        $this->client->request('GET', '/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testListAction()
    {
        $this->repository->findAll();
        $this->logIn(['ROLE_USER']);
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        // show the create page
        $this->logIn(['ROLE_USER']);
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // submit create form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'title';
        $form['task[content]'] = 'content';
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        // redirect to task list page
        $this->client->followRedirect();
        $this->assertContains("La tâche a été bien été ajoutée.", $this->client->getResponse()->getContent());
    }

    public function testEditAction()
    {
        // show the edit page
        $this->logIn(['ROLE_USER']);
        $crawler = $this->client->request('GET', '/tasks/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit Task
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'title';
        $form['task[content]'] = 'content';
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        // redirect task list page
        $this->client->followRedirect();
        $this->assertContains("La tâche a bien été modifiée.", $this->client->getResponse()->getContent());
    }

    public function testToggleAction()
    {
        $this->logIn(['ROLE_USER']);
        $this->client->request('GET', '/tasks/1/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertContains(" La tâche title a bien été marquée comme faite.", $this->client->getResponse()->getContent());
    }

    public function testDeleteAction()
    {
        $this->logIn(['ROLE_USER']);
        // Id just can be test once
        $this->client->request('GET', 'tasks/10/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }
}
