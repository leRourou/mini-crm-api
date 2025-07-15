<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Company::class, 20, function (Company $company) {
            $company->setName($this->faker->company);
            $company->setDescription($this->faker->catchPhrase);
            $company->setWebsite($this->faker->domainName);
            $company->setAddress($this->faker->address);
            $company->setPhone($this->faker->phoneNumber);
        });

        $manager->flush();
    }
}
