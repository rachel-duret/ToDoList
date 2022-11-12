<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function findAllUserService()
    {
        return $this->userRepository->findAll();
    }

    public function creatOneUserService(User $user)
    {
        $password = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function editOneUserService(User $user)
    {
        $password = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        //dd($user);
        $this->em->flush();
    }
}
