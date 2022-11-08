<?php

namespace App\Tests\Trait;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;


trait LoginTest
{
    public function getLoggedUser(KernelBrowser $client)
    {
        $this->userRepository = $client->getContainer()->get('doctrine')->getRepository(User::class);

        $this->user = $this->userRepository->findOneByEmail('username0@mail.com');

        return $this->client->loginUser($this->user);
    }
}
