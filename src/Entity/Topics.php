<?php

namespace App\Entity;

use App\Repository\TopicsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=TopicsRepository::class)
 */
class Topics implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\Column(type="integer")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Discipline", mappedBy="topics")
     */
    private $dicipline;

    public function __construct()
    {
        $this->dicipline = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDicipline()
    {
        return $this->dicipline;
    }

    public function setDicipline(ArrayCollection $dicipline): void
    {
        $this->dicipline = $dicipline;
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
            'description' => $this->getDescription(),
            'amountHours' => $this->getAmountHours(),
            'disipline' => $this->getDicipline()->toArray(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
        ];
    }
}
