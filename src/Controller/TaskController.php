<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    #[Route(path: '/tasks', name: 'task_list')]
    #[IsGranted("ROLE_USER", message: 'Page not found.')]
    public function listAction(TaskRepository $taskRepository): Response
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findAll()]);
    }

    #[Route(path: '/tasks/create', name: 'task_create')]
    #[IsGranted("ROLE_USER", message: 'Page not found.')]
    public function createAction(Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // add task owner to the database
            $task->setUser($this->getUser());
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route(path: '/tasks/{id}/edit', name: 'task_edit')]
    #[IsGranted("ROLE_USER", message: 'Page not found.')]
    public function editAction(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        //check logged user is same as task's owner
        if ($this->getUser() !== $task->getUser()) {
            return $this->redirectToRoute('task_list');
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route(path: '/tasks/{id}/toggle', name: 'task_toggle')]
    #[IsGranted("ROLE_USER", message: 'Page not found')]
    public function toggleTaskAction(Task $task, EntityManagerInterface $em): Response
    {
        //check logged user is same as task's owner
        if ($this->getUser() !== $task->getUser()) {
            $this->addFlash('danger', "Vous n'avez pas le droit de modifier la tâche.");
            return $this->redirectToRoute('task_list');
        }
        $task->toggle(!$task->isDone());
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route(path: '/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(int $id,  EntityManagerInterface $em, TaskRepository $taskRepository): Response
    {
        $task = $taskRepository->find($id);
        if (empty($task)) {
            $this->addFlash('danger', 'Page not found');
            return $this->redirectToRoute('task_list');
        }
        if ($task->getUser()->getUsername() === 'anonyme' && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $this->addFlash('danger', 'Only admin can delete this task');
            return $this->redirectToRoute('task_list');
        }

        //check logged user is same as task's owner
        if ($this->getUser() !== $task->getUser() && !$task->getUser()->getUsername() === 'anonyme') {
            $this->addFlash('danger', "Vous n'avez pas le droit de supprimer la tâche.");
            return $this->redirectToRoute('task_list');
        }

        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
