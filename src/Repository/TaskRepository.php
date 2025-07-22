<?php

namespace App\Repository;

use App\Contract\TaskRepositoryInterface;
use App\Entity\Task;
use App\Entity\TaskStatus;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findByContact(int $contactId): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('t')
                ->andWhere('t.contact = :contactId')
                ->setParameter('contactId', $contactId)
                ->orderBy('t.dueDate', 'ASC')
        );
    }

    public function findByStatus(TaskStatus $status): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('t')
                ->andWhere('t.status = :status')
                ->setParameter('status', $status)
                ->orderBy('t.dueDate', 'ASC')
        );
    }

    public function findOverdue(\DateTimeInterface $date): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('t')
                ->andWhere('t.dueDate < :date')
                ->andWhere('t.status = :status')
                ->setParameter('date', $date)
                ->setParameter('status', TaskStatus::PENDING)
                ->orderBy('t.dueDate', 'ASC')
        );
    }

    public function findDueSoon(\DateTimeInterface $date): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('t')
                ->andWhere('t.dueDate <= :date')
                ->andWhere('t.status = :status')
                ->setParameter('date', $date)
                ->setParameter('status', TaskStatus::PENDING)
                ->orderBy('t.dueDate', 'ASC')
        );
    }
}