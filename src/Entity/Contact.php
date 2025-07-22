<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ContactRepository;
use App\Trait\CollectionManagerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['firstname' => 'partial', 'email' => 'exact'])]
#[ApiResource(
    normalizationContext: ['groups' => ['contact:read', 'timestampable:read']],
    denormalizationContext: ['groups' => ['contact:write']],
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
class Contact extends Timestampable
{
    use CollectionManagerTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'contact:read',
        'contact:write',
        'company:read',
        'opportunity:read',
        'note:read',
        'task:read',
    ])]
    #[Assert\NotBlank]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'contact:read',
        'contact:write',
        'company:read',
        'opportunity:read',
        'note:read',
        'task:read',
    ])]
    #[Assert\NotBlank]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write'])]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write'])]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[Groups(['contact:read', 'contact:write'])]
    private ?Company $company = null;

    #[ORM\OneToMany(targetEntity: Opportunity::class, mappedBy: 'contact', cascade: ['remove'])]
    #[Groups(['contact:item'])]
    private Collection $opportunities;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'contact', cascade: ['remove'])]
    #[Groups(['contact:item'])]
    private Collection $notes;

    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'contact', cascade: ['remove'])]
    #[Groups(['contact:item'])]
    private Collection $tasks;

    public function __construct()
    {
        $this->opportunities = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getOpportunities(): Collection
    {
        return $this->opportunities;
    }

    public function addOpportunity(Opportunity $opportunity): static
    {
        return $this->addToCollection(
            $this->opportunities,
            $opportunity,
            fn($item, $parent) => $item->setContact($parent)
        );
    }

    public function removeOpportunity(Opportunity $opportunity): static
    {
        return $this->removeFromCollection(
            $this->opportunities,
            $opportunity,
            fn($item) => $item->getContact(),
            fn($item, $value) => $item->setContact($value)
        );
    }

    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        return $this->addToCollection(
            $this->notes,
            $note,
            fn($item, $parent) => $item->setContact($parent)
        );
    }

    public function removeNote(Note $note): static
    {
        return $this->removeFromCollection(
            $this->notes,
            $note,
            fn($item) => $item->getContact(),
            fn($item, $value) => $item->setContact($value)
        );
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        return $this->addToCollection(
            $this->tasks,
            $task,
            fn($item, $parent) => $item->setContact($parent)
        );
    }

    public function removeTask(Task $task): static
    {
        return $this->removeFromCollection(
            $this->tasks,
            $task,
            fn($item) => $item->getContact(),
            fn($item, $value) => $item->setContact($value)
        );
    }
}
