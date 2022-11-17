<?php

namespace App\Tests\Service;

use App\Entity\Task;
use App\Entity\User;
use App\Tests\Trait\LoginTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskServiceTest extends WebTestCase
{
    use LoginTest;

    public function setUp(): void
    {
        //create http client 
        $this->client = static::createClient();
        $this->taskRepository = $this->client->getContainer()->get('doctrine')->getRepository(Task::class);
        $this->em = $this->client->getContainer()->get('doctrine.orm.default_entity_manager');
    }

    public function testFindAllUserService()
    {

        $tasks = $this->taskRepository->count([]);
        $this->assertEquals(12, $tasks);
    }

    public function testCreateOneTaskService()
    {
        $this->userRepository = $this->client->getContainer()->get('doctrine')->getRepository(User::class);

        $this->user = $this->userRepository->findOneByEmail('username@mail.com');
        $task = new Task();
        $task->setTitle('task');
        $task->setContent('task content');
        $task->setUser($this->user);
        $this->em->persist($task);
        $this->em->flush();
        $this->assertEquals('task', $task->getTitle());
    }

    public function testEditOneTaskService()
    {
        $task = new Task();
        $task->setTitle('taskup');
        $task->setContent('task content');
        $this->em->flush();
        $this->assertEquals('taskup', $task->getTitle());
    }

    public function testDeleteOneTaskService()
    {

        $task = $this->taskRepository->find(40);

        $this->em->remove($task);
        $this->em->flush();
        $this->assertEquals(null, $task->getId());
    }

    public function testSetOneTaskToggleService()
    {
        $task = $this->taskRepository->find(39);
        $task->isDone(false);
        $this->em->flush();
        $this->assertEquals(false, $task->isDone());
    }
}
