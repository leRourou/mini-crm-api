<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Company::class, 261, function (Company $company) {
            $company->setName($this->faker->company)
                ->setDescription($this->faker->catchPhrase)
                ->setWebsite($this->faker->domainName)
                ->setAddress($this->faker->address)
                ->setPhone($this->faker->phoneNumber);
        });

        $this->flush();
    }
}
