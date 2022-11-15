<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();
    }

    public function getUserEntity()
    {
        $user = new User();
        $user->setUsername('user1');
        $user->setPassword('password');
        $user->setEmail('user1@mail.com');
        $user->setRoles(['ROLR_USER']);

        return $user;
    }

    public function testUserEntityIsValid()
    {
        $user = $this->getUserEntity();
        $errors = $this->container->get('validator')->validate($user);

        $this->assertCount(0, $errors);
    }

    public function testUserEntityUsernameUnValid()
    {
        $user = $this->getUserEntity();
        $user->setUsername('');
        $errors = $this->container->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }

    public function testUserEntityPasswordUnValid()
    {

        $user = $this->getUserEntity();
        $user->setPassword('');
        $errors = $this->container->get('validator')->validate($user);
        $this->assertCount(2, $errors);
    }

    public function testUserEntityEmailUnValid()
    {

        $user = $this->getUserEntity();
        $user->setEmail('useremail');
        $errors = $this->container->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }
}
