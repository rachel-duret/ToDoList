<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $userAnonyme = new User();
        $userAnonyme->setUsername('anonyme');
        $userAnonyme->setPassword($this->userPasswordHasher->hashPassword($userAnonyme, "password"));
        $userAnonyme->setEmail("anonyme@mail.com");
        $userAnonyme->setRoles(['ROLE_USER']);
        $manager->persist($userAnonyme);

        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $userAdmin->setEmail("admin@mail.com");
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($userAdmin);




        $user = new User();
        $user->setUsername('username');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $user->setEmail("username@mail.com");
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);


        $manager->flush();

        $this->addReference('user_anonyme', $userAnonyme);
        $this->addReference('user_admin', $userAdmin);
        $this->addReference('user', $user);
    }
}
