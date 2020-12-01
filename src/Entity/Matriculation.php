<?php

namespace App\Entity;

use App\Repository\MatriculationRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MatriculationRepository::class)
 */
class Matriculation implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="o Ra não pode ser nulo", payload={"severity"="error"})
     * @Assert\Type(type="integer")
     */
    private int $academicRecord;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="matriculations")
     */
    private ?Student $student = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes", inversedBy="matriculations")
     */
    private ?Classes $classe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcademicRecord(): ?int
    {
        return $this->academicRecord;
    }

    public function setAcademicRecord(int $academicRecord): self
    {
        $this->academicRecord = $academicRecord;

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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): void
    {
        $this->student = $student;
    }

    public function getClasse(): ?Classes
    {
        return $this->classe;
    }

    public function setClasse(?Classes $classe): void
    {
        $this->classe = $classe;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'academicRecord' => $this->getAcademicRecord(),
            'classe' => $this->getClasse(),
            'student' => $this->getStudent(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
        ];
    }
}
