<?php

namespace App\ValueObject;

final readonly class Money
{
    public function __construct(
        private float $amount,
        private string $currency = 'USD'
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount cannot be negative');
        }
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(Money $other): Money
    {
        if ($this->currency !== $other->currency) {
            throw new \InvalidArgumentException('Cannot add different currencies');
        }

        return new self($this->amount + $other->amount, $this->currency);
    }

    public function subtract(Money $other): Money
    {
        if ($this->currency !== $other->currency) {
            throw new \InvalidArgumentException('Cannot subtract different currencies');
        }

        $newAmount = $this->amount - $other->amount;
        if ($newAmount < 0) {
            throw new \InvalidArgumentException('Result cannot be negative');
        }

        return new self($newAmount, $this->currency);
    }

    public function multiply(float $multiplier): Money
    {
        if ($multiplier < 0) {
            throw new \InvalidArgumentException('Multiplier cannot be negative');
        }

        return new self($this->amount * $multiplier, $this->currency);
    }

    public function equals(Money $other): bool
    {
        return $this->amount === $other->amount && $this->currency === $other->currency;
    }

    public function isGreaterThan(Money $other): bool
    {
        if ($this->currency !== $other->currency) {
            throw new \InvalidArgumentException('Cannot compare different currencies');
        }

        return $this->amount > $other->amount;
    }

    public function format(): string
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }

    public function __toString(): string
    {
        return (string) $this->amount;
    }
}