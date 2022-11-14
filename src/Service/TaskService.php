<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TaskRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TaskRepository $taskRepository
    ) {
    }

    public function findOneTaskService(int $id)
    {
        return $this->taskRepository->find($id);
    }

    public function findAllTaskService()
    {
        return $this->taskRepository->findAll();
    }

    public function createOneTaskService(Task $task, UserInterface $loggedUser)
    {
        // add task owner to the database
        $task->setUser($loggedUser);
        $this->em->persist($task);
        $this->em->flush();
    }

    public function editOneTaskService()
    {
        $this->em->flush();
    }

    public function deleteOneTaskService(Object $task)
    {
        $this->em->remove($task);
        $this->em->flush();
    }

    public function setOneTaskToggle(object $task)
    {
        $task->toggle(!$task->isDone());
        $this->em->flush();
    }
}
