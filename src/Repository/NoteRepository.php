<?php

namespace App\Repository;

use App\Contract\NoteRepositoryInterface;
use App\Entity\Note;

use Doctrine\Persistence\ManagerRegistry;

class NoteRepository extends BaseRepository implements NoteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }



    public function findByContact(int $contactId): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('n')
                ->andWhere('n.contact = :contactId')
                ->setParameter('contactId', $contactId)
                ->orderBy('n.createdAt', 'DESC')
        );
    }

    public function findRecentNotes(\DateTimeInterface $since): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('n')
                ->andWhere('n.createdAt >= :since')
                ->setParameter('since', $since)
                ->orderBy('n.createdAt', 'DESC')
        );
    }

    public function searchByContent(string $searchTerm): array
    {
        return $this->executeQuery(
            $this->createBaseQueryBuilder('n')
                ->andWhere('n.content LIKE :searchTerm OR n.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%')
                ->orderBy('n.createdAt', 'DESC')
        );
    }
}
