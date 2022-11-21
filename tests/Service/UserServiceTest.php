<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\UserService;
use App\Tests\Trait\LoginTest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceTest extends KernelTestCase
{
    use LoginTest;
    private $taskRepository;


    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->userRepository = $kernel->getContainer()->get('doctrine')->getRepository(User::class);
        $this->userService = $kernel->getContainer()->get(UserService::class);
    }


    public function testFindOneUserService()
    {
        $user = $this->userService->findOneUserService(16);
        $this->assertEquals('admin', $user->getUsername());
        $this->assertEquals('admin@mail.com', $user->getEmail());
        $this->assertEquals(16, $user->getId());
    }

    public function testFindAllUserService()
    {

        $users = $this->userService->findAllUserService();
        $this->assertIsArray($users);
    }

    public function testCreateOneUserService()
    {
        $user = new User();
        $user->setUsername('username1 test');
        $user->setPassword('passwordtest');
        $user->setEmail('username1test@mail.com');
        $user->setRoles(["ROLE_USER"]);
        $this->userService->creatOneUserService($user);
        $this->assertEquals('username1 test', $user->getUsername());
        $this->assertEquals('username1test@mail.com', $user->getEmail());
        $this->assertNotNull($this->userRepository->findById($user->getId()));
    }

    public function testEditOneUserService()
    {
        $user = new User();
        $user->setUsername('username up');
        $user->setPassword('passwordtest');
        $user->setEmail('username1test@mail.com');
        $user->setRoles(["ROLE_USER"]);
        $this->userService->editOneUserService($user);
        $this->assertEquals('username up', $user->getUsername());
    }
}
