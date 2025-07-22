<?php

namespace App\Contract;

use App\Entity\Task;
use App\Entity\TaskStatus;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function findByContact(int $contactId): array;

    public function findByStatus(TaskStatus $status): array;

    public function findOverdue(\DateTimeInterface $date): array;

    public function findDueSoon(\DateTimeInterface $date): array;
}