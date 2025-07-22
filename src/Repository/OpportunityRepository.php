<?php

namespace App\Repository;

use App\Contract\OpportunityRepositoryInterface;
use App\Entity\Opportunity;
use App\Entity\OpportunityStatus;
use Doctrine\Persistence\ManagerRegistry;

class OpportunityRepository extends BaseRepository implements OpportunityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opportunity::class);
    }

    public function findByContact(int $contactId): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('o')
                ->andWhere('o.contact = :contactId')
                ->setParameter('contactId', $contactId)
                ->orderBy('o.closeDate', 'ASC')
        );
    }

    public function findByStatus(OpportunityStatus $status): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('o')
                ->andWhere('o.status = :status')
                ->setParameter('status', $status)
                ->orderBy('o.closeDate', 'ASC')
        );
    }

    public function findClosingSoon(\DateTimeInterface $date): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('o')
                ->andWhere('o.closeDate <= :date')
                ->andWhere('o.status IN (:openStatuses)')
                ->setParameter('date', $date)
                ->setParameter('openStatuses', [OpportunityStatus::PROSPECT, OpportunityStatus::QUALIFIED])
                ->orderBy('o.closeDate', 'ASC')
        );
    }

    public function getTotalAmountByStatus(OpportunityStatus $status): float
    {
        $result = $this->createBaseQueryBuilder('o')
            ->select('SUM(o.amount)')
            ->andWhere('o.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getSingleScalarResult();

        return (float) ($result ?? 0);
    }
}