<?php

namespace App\Core\ValueObject;

class ContactName
{
    public function __construct(
        private string $firstname,
        private string $lastname
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty(trim($this->firstname)) || empty(trim($this->lastname))) {
            throw new \InvalidArgumentException('First name and last name cannot be empty');
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
        return $this->firstname . ' ' . $this->lastname;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }
}