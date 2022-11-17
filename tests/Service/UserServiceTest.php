<?php

namespace App\Tests\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class UserServiceTest extends WebTestCase
{
    private EntityManagerInterface $em;

    public function setUp(): void
    {
        //create http client 
        $this->client = static::createClient();
        $this->userRepository = $this->client->getContainer()->get('doctrine')->getRepository(User::class);
        $this->em = $this->client->getContainer()->get('doctrine.orm.default_entity_manager');
    }

    public function testFindAllUserService()
    {

        $users = $this->userRepository->count([]);
        $this->assertEquals(3, $users);
    }

    public function testCreateOneUserService()
    {
        $user = new User();
        $user->setUsername('username1 test');
        $user->setPassword('passwordtest');
        $user->setEmail('username1test@mail.com');
        $user->setRoles(["ROLE_USER"]);
        $this->em->persist($user);
        $this->em->flush();
        $this->assertEquals('username1 test', $user->getUsername());
    }

    public function testEditOneUserService()
    {
        $user = new User();
        $user->setUsername('username up');
        $user->setPassword('passwordtest');
        $user->setEmail('username1test@mail.com');
        $user->setRoles(["ROLE_USER"]);
        $this->em->persist($user);
        $this->em->flush();
        $this->assertEquals('username up', $user->getUsername());
    }
}
