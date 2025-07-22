<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OpportunityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OpportunityRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['opportunity:read', 'timestampable:read']],
    denormalizationContext: ['groups' => ['opportunity:write']],
    paginationItemsPerPage: 30,
    paginationMaximumItemsPerPage: 100,
    paginationClientItemsPerPage: true,
    paginationClientEnabled: true,
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
class Opportunity extends Timestampable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['opportunity:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'opportunities')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups(['opportunity:read', 'opportunity:write', 'contact:read'])]
    private ?Contact $contact = null;

    #[ORM\Column(length: 255)]
    #[Groups(['opportunity:read', 'opportunity:write'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['opportunity:read', 'opportunity:write'])]
    private ?string $description = null;

    #[ORM\Column(enumType: OpportunityStatus::class)]
    #[Groups(['opportunity:read', 'opportunity:write'])]
    private ?OpportunityStatus $status = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['opportunity:read', 'opportunity:write'])]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['opportunity:read', 'opportunity:write'])]
    private ?\DateTime $closeDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?OpportunityStatus
    {
        return $this->status;
    }

    public function setStatus(OpportunityStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCloseDate(): ?\DateTime
    {
        return $this->closeDate;
    }

    public function setCloseDate(\DateTime $closeDate): static
    {
        $this->closeDate = $closeDate;

        return $this;
    }
}
