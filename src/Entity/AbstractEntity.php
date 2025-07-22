<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\MappedSuperclass]
abstract class AbstractEntity extends Timestampable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function equals(AbstractEntity $other): bool
    {
        return $this->getId() === $other->getId() && static::class === $other::class;
    }

    abstract public function __toString(): string;
}