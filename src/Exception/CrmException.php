<?php

namespace App\Exception;

abstract class CrmException extends \Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    abstract public function getStatusCode(): int;

    public function getContext(): array
    {
        return [];
    }
}