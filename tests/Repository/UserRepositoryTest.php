<?php

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
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

        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function testFindUserById()
    {
        $user = $this->userRepository->find(16);

        $this->assertSame(16, $user->getId());
    }

    public function testFindUserByUsername()
    {
        $user =  $this->userRepository->findOneBy(['username' => 'admin']);

        $this->assertSame('admin', $user->getUsername());
    }

    public function testFindUserByEmail()
    {
        $user = $this->userRepository->findBy(['email' => 'admin@mail.com']);

        $this->assertIsArray($user);
    }

    public function testFindAllUsers()
    {
        $users = $this->userRepository->findAll();

        $this->assertIsArray($users);
    }
}
