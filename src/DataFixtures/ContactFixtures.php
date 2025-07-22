<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Contact;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager): void
    {
        $companies = $manager->getRepository(Company::class)->findAll();

        $this->createMany(Contact::class, 324, function (Contact $contact) use ($companies) {
            $contact->setFirstname($this->faker->firstName)
                ->setLastname($this->faker->lastName)
                ->setEmail($this->faker->unique()->email)
                ->setPhone($this->faker->phoneNumber)
                ->setCompany($this->getRandomElement($companies));
        });

        $this->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
