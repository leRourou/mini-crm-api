<?php

namespace App\Exception;

class EntityNotFoundException extends CrmException
{
    public function __construct(
        private readonly string $entityType,
        private readonly mixed $identifier,
        ?\Throwable $previous = null
    ) {
        $message = sprintf('Entity "%s" with identifier "%s" was not found', $entityType, $identifier);
        parent::__construct($message, 0, $previous);
    }

    public function getStatusCode(): int
    {
        return 404;
    }

    public function getContext(): array
    {
        return [
            'entity_type' => $this->entityType,
            'identifier' => $this->identifier,
        ];
    }
}