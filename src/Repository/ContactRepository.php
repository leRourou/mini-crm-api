<?php

namespace App\Repository;

use App\Contract\ContactRepositoryInterface;
use App\Entity\Contact;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findByEmail(string $email): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('c')
                ->andWhere('c.email = :email')
                ->setParameter('email', $email)
                ->orderBy('c.lastname', 'ASC')
                ->addOrderBy('c.firstname', 'ASC')
        );
    }

    public function findByCompany(int $companyId): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('c')
                ->andWhere('c.company = :companyId')
                ->setParameter('companyId', $companyId)
                ->orderBy('c.lastname', 'ASC')
                ->addOrderBy('c.firstname', 'ASC')
        );
    }

    public function findByName(string $firstname, ?string $lastname = null): array
    {
        $qb = $this->createBaseQueryBuilder('c')
            ->andWhere('c.firstname LIKE :firstname')
            ->setParameter('firstname', '%' . $firstname . '%');

        if ($lastname !== null) {
            $qb->andWhere('c.lastname LIKE :lastname')
               ->setParameter('lastname', '%' . $lastname . '%');
        }

        return $this->executeQuery(
            $qb->orderBy('c.lastname', 'ASC')
               ->addOrderBy('c.firstname', 'ASC')
        );
    }
}
