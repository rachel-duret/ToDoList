<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;

class UserService
{

    public function __construct(private EntityManagerInterface $em, private UserRepository $userRepository)
    {
    }

    public function findAllUserService()
    {
        return $this->userRepository->findAll();
    }

    public function creatUserService(User $user)
    {
        $password = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);

        $this->em->persist($user);
        $$this->em->flush();
    }

    public function editUserService(User $user)
    {
        $password = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);

        $this->em->flush();
    }
}
