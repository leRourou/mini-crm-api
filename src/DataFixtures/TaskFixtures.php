<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Task;
use App\Entity\TaskStatus;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager): void
    {
        $contacts = $manager->getRepository(Contact::class)->findAll();

        $this->createMany(Task::class, 100, function (Task $task) use ($contacts) {
            $task->setDescription($this->faker->sentence(10));
            $task->setDueDate($this->faker->dateTimeBetween('now', '+1 year'));
            $task->setStatus($this->faker->randomElement(TaskStatus::cases()));
            $task->setContact($this->faker->randomElement($contacts));
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ContactFixtures::class,
        ];
    }
}
