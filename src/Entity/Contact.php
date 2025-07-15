<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['firstname' => 'partial', 'email' => 'exact'])]
class Contact extends Timestampable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contact:read', 'company:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write', 'company:read'])]
    #[Assert\NotBlank]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write', 'company:read'])]
    #[Assert\NotBlank]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write', 'company:read'])]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write', 'company:read'])]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[Groups(['contact:read', 'contact:write'])]
    private ?Company $company = null;

    /**
     * @var Collection<int, Opportunity>
     */
    #[ORM\OneToMany(targetEntity: Opportunity::class, mappedBy: 'contact', cascade: ['remove'])]
    #[Groups(['contact:item'])]
    private Collection $opportunities;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'contact', cascade: ['remove'])]
    #[Groups(['contact:item'])]
    private Collection $notes;

    /**
     * @var Collection<int, Task>
     */
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

    /**
     * @return Collection<int, Opportunity>
     */
    public function getOpportunities(): Collection
    {
        return $this->opportunities;
    }

    public function addOpportunity(Opportunity $opportunity): static
    {
        if (!$this->opportunities->contains($opportunity)) {
            $this->opportunities->add($opportunity);
            $opportunity->setContact($this);
        }

        return $this;
    }

    public function removeOpportunity(Opportunity $opportunity): static
    {
        if ($this->opportunities->removeElement($opportunity)) {
            // set the owning side to null (unless already changed)
            if ($opportunity->getContact() === $this) {
                $opportunity->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setContact($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getContact() === $this) {
                $note->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setContact($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getContact() === $this) {
                $task->setContact(null);
            }
        }

        return $this;
    }
}
