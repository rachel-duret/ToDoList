<?php

namespace App\Tests\Service;

use App\Entity\Task;
use App\Entity\User;
use App\Service\TaskService;
use App\Tests\Trait\LoginTest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class TaskServiceTest extends KernelTestCase
{
    use LoginTest;
    private $taskService;
    private $taskRepository;


    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->taskRepository = $kernel->getContainer()->get('doctrine')->getRepository(Task::class);
        $this->userRepository = $kernel->getContainer()->get('doctrine')->getRepository(User::class);
        $this->taskService = $kernel->getContainer()->get(TaskService::class);
    }

    public function testFindOneTaskService()
    {
        $task = $this->taskService->findOneTaskService(40);
        $this->assertEquals('taskAdminTitle', $task->getTitle());
        $this->assertEquals('taskAdminContent', $task->getContent());
        $this->assertEquals(40, $task->getId());
    }


    public function testFindAllTaskService()
    {

        $tasks = $this->taskService->findAllTaskService();
        $this->assertIsArray($tasks);
    }

    public function testCreateOneTaskService()
    {


        $this->user = $this->userRepository->findOneByEmail('username@mail.com');
        $task = new Task();
        $task->setTitle('task');
        $task->setContent('task content');
        $this->taskService->createOneTaskService($task, $this->user);
        $this->assertEquals('task', $task->getTitle());
        $this->assertEquals($this->user, $task->getUser());
        $this->assertNotNull($this->taskRepository->findById($task->getId()));
    }

    public function testEditOneTaskService()
    {

        $task = $this->taskService->findOneTaskService(30);

        $task->setTitle('taskup');
        $task->setContent('task content');
        $this->taskService->editOneTaskService();
        $this->assertEquals('taskup', $task->getTitle());
    }

    public function testDeleteOneTaskService()
    {

        $task = $this->taskService->findOneTaskService(40);

        $this->taskService->deleteOneTaskService($task);
        $this->assertEquals(null, $task->getId());
    }


    public function testSetOneTaskToggleService()
    {
        $task = $this->taskService->findOneTaskService(30);
        $this->taskService->setOneTaskToggle($task);
        $this->assertEquals(true, $task->isDone());
    }
}
