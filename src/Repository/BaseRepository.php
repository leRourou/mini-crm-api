<?php

namespace App\Repository;

use App\Contract\RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function save(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    protected function createBaseQueryBuilder(string $alias): \Doctrine\ORM\QueryBuilder
    {
        return $this->createQueryBuilder($alias);
    }

    protected function executeQuery(\Doctrine\ORM\QueryBuilder $qb): array
    {
        return $qb->getQuery()->getResult();
    }

    protected function executeSingleResult(\Doctrine\ORM\QueryBuilder $qb): ?object
    {
        return $qb->getQuery()->getOneOrNullResult();
    }
}