<?php

namespace App\Contract;

use App\Entity\Contact;

interface ContactRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email): array;

    public function findByCompany(int $companyId): array;

    public function findByName(string $firstname, ?string $lastname = null): array;
}