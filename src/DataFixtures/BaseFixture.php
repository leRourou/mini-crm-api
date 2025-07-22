<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    protected ObjectManager $manager;
    protected Generator $faker;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    abstract protected function loadData(ObjectManager $manager): void;

    protected function createMany(string $className, int $count, callable $factory): array
    {
        $entities = [];
        
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            $entities[] = $entity;
        }
        
        return $entities;
    }

    protected function createOne(string $className, callable $factory): object
    {
        $entity = new $className();
        $factory($entity);
        $this->manager->persist($entity);
        
        return $entity;
    }

    protected function getRandomElements(array $array, int $count = 1): array
    {
        if ($count === 1) {
            return [$this->faker->randomElement($array)];
        }
        
        return $this->faker->randomElements($array, $count);
    }

    protected function getRandomElement(array $array): mixed
    {
        return $this->faker->randomElement($array);
    }

    protected function flush(): void
    {
        $this->manager->flush();
    }
}
