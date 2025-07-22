<?php

namespace App\Contract;

use App\Entity\Opportunity;
use App\Entity\OpportunityStatus;

interface OpportunityRepositoryInterface extends RepositoryInterface
{
    public function findByContact(int $contactId): array;

    public function findByStatus(OpportunityStatus $status): array;

    public function findClosingSoon(\DateTimeInterface $date): array;

    public function getTotalAmountByStatus(OpportunityStatus $status): float;
}