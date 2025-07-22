<?php

namespace App\ValueObject;

final readonly class ContactName
{
    public function __construct(
        private string $firstname,
        private string $lastname
    ) {
        if (empty(trim($firstname))) {
            throw new \InvalidArgumentException('First name cannot be empty');
        }
        if (empty(trim($lastname))) {
            throw new \InvalidArgumentException('Last name cannot be empty');
        }
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFullName(): string
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    public function getInitials(): string
    {
        return strtoupper(
            substr($this->firstname, 0, 1) . substr($this->lastname, 0, 1)
        );
    }

    public function equals(ContactName $other): bool
    {
        return $this->firstname === $other->firstname && $this->lastname === $other->lastname;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }
}