<?php

namespace App\Contract;

use App\Entity\Company;

interface CompanyRepositoryInterface extends RepositoryInterface
{
    public function findByName(string $name): array;

    public function findByWebsite(string $website): array;
}