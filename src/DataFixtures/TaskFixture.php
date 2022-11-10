<?php

namespace App\DataFixtures;

use App\Entity\Task;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle('taskTitle' . $i);
            $task->setContent('taskContent' . $i);
            $task->isDone(0);
            $task->setCreatedAt(new DateTime());
            $task->setUser($this->getReference('user_anonyme'));
            $manager->persist($task);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}
