<?php

namespace App\Repository;

use App\Contract\CompanyRepositoryInterface;
use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findByName(string $name): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('c')
                ->andWhere('c.name LIKE :name')
                ->setParameter('name', '%' . $name . '%')
                ->orderBy('c.name', 'ASC')
        );
    }

    public function findByWebsite(string $website): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('c')
                ->andWhere('c.website = :website')
                ->setParameter('website', $website)
                ->orderBy('c.name', 'ASC')
        );
    }
}
