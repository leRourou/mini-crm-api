<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    protected function loadData(ObjectManager $manager): void
    {
        $adminUser = new User();
        $adminUser->setEmail('admin@example.com');
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, 'password'));
        $manager->persist($adminUser);

        $this->createMany(User::class, 10, function (User $user) {
            $user->setEmail($this->faker->email);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        });

        $manager->flush();
    }
}
