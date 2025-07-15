<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Opportunity;
use App\Entity\OpportunityStatus;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OpportunityFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $contacts = $manager->getRepository(Contact::class)->findAll();

        $this->createMany(Opportunity::class, 50, function (Opportunity $opportunity) use ($contacts) {
            $opportunity->setTitle($this->faker->sentence(3));
            $opportunity->setDescription($this->faker->sentence(10));
            $opportunity->setStatus($this->faker->randomElement(OpportunityStatus::cases()));
            $opportunity->setAmount($this->faker->randomFloat(2, 100, 10000));
            $opportunity->setCloseDate($this->faker->dateTimeBetween('now', '+1 year'));
            $opportunity->setContact($this->faker->randomElement($contacts));
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
