<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
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

    /* *******************************CREATE ACTION******************************************** */
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
        $this->assertSelectorExists("div.caption", "test task");
    }
    /* ****************************EDIT ACTION******************************** */
    public function testTaskEditAction()
    {
        // show the edit page
        $this->getLoggedUser($this->client);
        $crawler = $this->client->request('GET', '/tasks/40/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit edit Task
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = ' taskAdminTitle update';
        $form['task[content]'] = 'taskAdminContent';


        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-success", "La tâche a bien été modifiée.");
        $this->assertSelectorExists("div.caption", "taskAdminTitle update");
    }

    public function testEditeOneTaskNotExist()
    {
        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/400/edit');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-danger", "Page not found");
    }

    public function testEditOneTaskNotOwner()
    {
        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/41/edit');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-danger", "Vous n'avez pas le droit de modifier la tâche.");
    }
    /* *****************************TOGGLE ACTION*************************** */
    public function testOneTaskToggleNotExit()
    {
        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/400/edit');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-danger", "Page not found");
    }

    public function testOneTaskToggleNotOwner()
    {
        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/41/edit');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-danger", "Vous n'avez pas le droit de modifier la tâche.");
    }

    public function testTaskToggleAction()
    {
        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/40/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /* *************************DELETE ACTION******************************************** */
    public function testDeleteOneTaskNotExist()
    {
        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/400/delete');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-danger", "Page not found");
    }
    public function testDeleteOneTaskAction()
    {
        $this->getLoggedUser($this->client);
        // Id just can be test once
        $this->client->request('GET', 'tasks/40/delete');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorExists("div.alert-success", "La tâche a été bien été supprimée.");
    }

    public function testDeleteOnetaskNotOwner()
    {

        $this->getLoggedUser($this->client);
        $this->client->request('GET', '/tasks/41/edit');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // $this->assertSelectorTextContains("div.alert.alert-danger", "Vous n'avez pas le droit de supprimer la tâche.");
    }

    public function testDeleteOneTaskAnnoymNotAdmin()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine')->getRepository(User::class);

        $this->user = $this->userRepository->findOneByEmail('username@mail.com');

        $this->client->loginUser($this->user);
        $this->client->request('GET', '/tasks/30/delete');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("div.alert.alert-danger", "Only admin can delete this task");
    }
}
