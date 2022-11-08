<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Tests\Trait\LoginTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    use LoginTest;
    private $client = null;

    public function setUp(): void
    {
        //create http client 
        $this->client = static::createClient();
        $this->repository = $this->client->getContainer()->get('doctrine')->getRepository(Task::class);
    }

    public function testTaskPageUserNotLogin()
    {
        $this->client->request('GET', '/tasks');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testTaskListAction()
    {
        $this->getLoggedUser($this->client);
        $this->repository->findAll();
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorNotExists("div.alert.alert-warning", " Il n'y a pas encore de tâche enregistrée.");
    }

    public function testTaskCreateAction()
    {
        // show the create page
        $this->getLoggedUser($this->client);
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // submit create form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = ' test task';
        $form['task[content]'] = 'new  content';


        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-success", "La tâche a été bien été ajoutée.");

        // redirect to user list page
        // $this->assertSelectorTextContains("p", "new content");
    }

    public function testTaskEditAction()
    {
        // show the edit page
        $this->getLoggedUser($this->client);
        $crawler = $this->client->request('GET', '/tasks/4/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit Task
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = ' update title';
        $form['task[content]'] = 'update content';


        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-success", "La tâche a bien été modifiée.");
        $this->assertSelectorTextContains("p", "update content");
    }

    public function testTaskToggleAction()
    {
        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/8/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testTaskDeleteAction()
    {
        $this->getLoggedUser($this->client);
        // Id just can be test once
        $this->client->request('GET', 'tasks/10/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }
}
