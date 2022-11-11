<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserService $userService
    ) {
    }


    /* **********User list********************************************* */
    #[Route(path: '/users', name: 'user_list')]
    public function listAction(): Response
    {
        $users = $this->userService->findAllUserService();
        return $this->render('user/list.html.twig', ['users' => $users]);
    }



    /* **********Create one user********************************************* */
    #[Route(path: '/users/create', name: 'user_create')]
    public function createAction(Request $request): Response
    {
        // Verify is Admin 
        if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $this->addFlash('danger', "page not found .");
            return $this->redirectToRoute('user_list');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Call UserService to insert data to database
            $this->userService->creatOneUserService($user);
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }
        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }



    /* **********Edit one User********************************************* */
    #[Route(path: '/users/{id}/edit', name: 'user_edit')]
    public function editAction(User $user, Request $request): Response
    {
        // Verify is Admin 
        if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $this->addFlash('danger', "page not found .");
            return $this->redirectToRoute('user_list');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Call UserService to update  data to database
            $this->userService->editOneUserService($user);

            $this->addFlash('success', "L'utilisateur a bien été modifié");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
