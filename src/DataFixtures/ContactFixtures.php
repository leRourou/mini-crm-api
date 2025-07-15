<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Contact;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $companies = $manager->getRepository(Company::class)->findAll();

        $this->createMany(Contact::class, 50, function (Contact $contact) use ($companies) {
            $contact->setFirstname($this->faker->firstName);
            $contact->setLastname($this->faker->lastName);
            $contact->setEmail($this->faker->email);
            $contact->setPhone($this->faker->phoneNumber);
            $contact->setCompany($this->faker->randomElement($companies));
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
