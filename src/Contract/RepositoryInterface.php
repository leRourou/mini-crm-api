<?php

namespace App\Contract;

interface RepositoryInterface
{
    public function find(int $id): ?object;
    public function findAll(): array;
    public function count(array $criteria): int;
    public function save(object $entity): void;
    public function remove(object $entity): void;
}