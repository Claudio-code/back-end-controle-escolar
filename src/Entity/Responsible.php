<?php

namespace App\Entity;

use App\Repository\ResponsibleRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResponsibleRepository::class)
 * @ORM\Table(name="responsibles")
 */
class Responsible implements JsonSerializable
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
     * @Assert\Email(
     *     message="O email '{{ value }}' não é um email valido"
     * )
     * @Assert\Type(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="o parentesco não pode ser nulo")
     * @Assert\Type(type="string")
     */
    private string $parentesco;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="O cpf não pode ser nulo"
     * )
     * @Assert\Type(type="string")
     */
    private string $cpf;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="O rg não pode ser nulo"
     * )
     * @Assert\Type(type="string")
     */
    private string $rg;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student")
     */
    private ?Student $student = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $updated_at = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getParentesco(): ?string
    {
        return $this->parentesco;
    }

    public function setParentesco(string $parentesco): self
    {
        $this->parentesco = $parentesco;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getRg(): ?string
    {
        return $this->rg;
    }

    public function setRg(string $rg): self
    {
        $this->rg = $rg;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
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

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'parentesco' => $this->getParentesco(),
            'cpf' => $this->getCpf(),
            'rg' => $this->getRg(),
            'status' => $this->getStatus(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
        ];
    }
}