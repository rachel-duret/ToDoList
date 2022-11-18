<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();
    }
    public function testTaskEntityIsValid()
    {
        $user = new User();
        $user->setUsername('user1');
        $user->setPassword('password');
        $user->setEmail('user1@mail.com');
        $user->setRoles(['ROLR_USER']);

        $errors = $this->container->get('validator')->validate($user);

        $this->assertCount(0, $errors);
    }

    public function testTaskEntityUsernameUnValid()
    {
        $user = new User();
        $user->setUsername('');
        $user->setPassword('password');
        $user->setEmail('user1@mail.com');
        $user->setRoles(['ROLR_USER']);

        $errors = $this->container->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }
}
