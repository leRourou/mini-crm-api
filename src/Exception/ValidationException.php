<?php

namespace App\Exception;

class ValidationException extends CrmException
{
    public function __construct(
        private readonly array $violations,
        ?\Throwable $previous = null
    ) {
        $message = 'Validation failed: ' . implode(', ', $violations);
        parent::__construct($message, 0, $previous);
    }

    public function getStatusCode(): int
    {
        return 400;
    }

    public function getContext(): array
    {
        return [
            'violations' => $this->violations,
        ];
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}