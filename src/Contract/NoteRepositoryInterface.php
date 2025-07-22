<?php

namespace App\Contract;

use App\Entity\Note;

interface NoteRepositoryInterface extends RepositoryInterface
{
    public function findByContact(int $contactId): array;

    public function findRecentNotes(\DateTimeInterface $since): array;

    public function searchByContent(string $searchTerm): array;
}