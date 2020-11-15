<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use JsonSerializable;
use Doctrine\Common\Collections\ArrayCollection;

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
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private string $amountHours;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Topics", inversedBy="dicipline")
     */
    private $topics;

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

    public function getTopics(): ArrayCollection
    {
        return $this->topics;
    }

    public function setTopics(ArrayCollection $topics): void
    {
        $this->topics = $topics;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
