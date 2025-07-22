<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Opportunity;
use App\Entity\OpportunityStatus;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OpportunityFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager): void
    {
        $contacts = $manager->getRepository(Contact::class)->findAll();

        $this->createMany(Opportunity::class, 90, function (Opportunity $opportunity) use ($contacts) {
            $opportunity->setTitle($this->faker->sentence(3))
                ->setDescription($this->faker->sentence(10))
                ->setStatus($this->getRandomElement(OpportunityStatus::cases()))
                ->setAmount($this->faker->randomFloat(2, 100, 10000))
                ->setCloseDate($this->faker->dateTimeBetween('now', '+1 year'))
                ->setContact($this->getRandomElement($contacts));
        });

        $this->flush();
    }

    public function getDependencies(): array
    {
        return [
            ContactFixtures::class,
        ];
    }
}
