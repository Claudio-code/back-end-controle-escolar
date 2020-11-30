<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DisciplineRepository::class)
 */
class Discipline implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="o nome não pode ser nulo", payload={"severity"="error"})
     * @Assert\Type(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="a descrição não pode ser nulo", payload={"severity"="error"})
     * @Assert\Type(type="string")
     */
    private string $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="a carga horaria não pode ser nula", payload={"severity"="error"})
     * @Assert\Type(type="integer")
     */
    private int $amountHours;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\Column(type="boolean", length=255)
     */
    private bool $status;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Topics", inversedBy="dicipline")
     */
    private $topics;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Teacher", inversedBy="coordinatedDisipline")
     */
    private ?Teacher $coordinator = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher", inversedBy="disciplines")
     */
    private ?Teacher $teacher = null;

    public function __construct()
    {
        $this->topics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmountHours(): ?int
    {
        return $this->amountHours;
    }

    public function setAmountHours(int $amountHours): self
    {
        $this->amountHours = $amountHours;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTopics()
    {
        return $this->topics;
    }

    public function setTopics(ArrayCollection $topics): void
    {
        $this->topics = $topics;
    }

    public function getCoordinator(): ?Teacher
    {
        return $this->coordinator;
    }

    public function getCoordinatorName()
    {
        return $this->coordinator;
    }

    public function setCoordinator(?Teacher $coordinator): void
    {
        $this->coordinator = $coordinator;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): void
    {
        $this->teacher = $teacher;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'amountHours' => $this->getAmountHours(),
            'description' => $this->getDescription(),
            'topics' => $this->getTopics()->toArray(),
            'coordinator' => $this->getCoordinator(),
            'teacher' => $this->getTeacher(),
            'status' => $this->isStatus(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
        ];
    }
}