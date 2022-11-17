<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{

    /**
     *  @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->taskRepository = $this->entityManager->getRepository(Task::class);
    }

    public function testFindTaskById()
    {
        $task =  $this->taskRepository->find(40);

        $this->assertSame(40, $task->getId());
    }

    public function testFindTaskByTitle()
    {
        $task =  $this->taskRepository->findBy(['title' => 'taskAdminTitle']);

        $this->assertIsArray($task);
    }

    public function testFindOneTaskBy()
    {
        $task =  $this->taskRepository->findOneBy(['title' => 'taskAdminTitle']);

        $this->assertSame('taskAdminTitle', $task->getTitle());
    }

    public function testFindAllTasks()
    {
        $tasks =  $this->taskRepository->findAll();

        $this->assertIsArray($tasks);
    }

    public function testRemoveOneTaskWithoutFlush()
    {
        $task =  $this->taskRepository->findOneBy(['title' => 'taskAdminTitle']);
        $this->entityManager->remove($task);

        $this->assertSame('taskAdminTitle', $task->getTitle());
    }

    public function testRemoveOneTaskWithFlush()
    {
        $task =  $this->taskRepository->findOneBy(['title' => 'taskAdminTitle']);
        $this->entityManager->remove($task);
        $this->entityManager->flush();
        $this->assertSame(null, $task->getId());
    }
}
