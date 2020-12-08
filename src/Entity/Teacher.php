<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher implements JsonSerializable
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
     * @Assert\NotBlank(message="O email não pode ser nulo")
     * @Assert\Email(
     *     message="O email não é um email valido"
     * )
     * @Assert\Type(type="string")
     */
    private string $email;

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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="o cnh não pode ser nulo"
     * )
     * @Assert\Type(type="string")
     */
    private string $cnh;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="a idade não pode ser nulo"
     * )
     * @Assert\Type(type="string")
     */
    private string $age;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="o titulo academico não pode ser nulo"
     * )
     * @Assert\Type(type="string")
     */
    private string $academicTitle;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Course", mappedBy="coordinator")
     */
    private ?Discipline $coordinatedCourse = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Discipline", mappedBy="teacher")
     */
    private $disciplines;

    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getCnh(): ?string
    {
        return $this->cnh;
    }

    public function setCnh(string $cnh): self
    {
        $this->cnh = $cnh;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAcademicTitle(): ?string
    {
        return $this->academicTitle;
    }

    public function setAcademicTitle(string $academicTitle): self
    {
        $this->academicTitle = $academicTitle;

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

    public function getDisciplines(): ArrayCollection
    {
        return $this->disciplines;
    }

    public function setDisciplines(ArrayCollection $disciplines): void
    {
        $this->disciplines = $disciplines;
    }

    public function getCoordinatedCourse(): ?Discipline
    {
        return $this->coordinatedCourse;
    }

    public function setCoordinatedCourse(?Discipline $coordinatedCourse): void
    {
        $this->coordinatedCourse = $coordinatedCourse;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'rg' => $this->getRg(),
            'cpf' => $this->getCpf(),
            'cnh' => $this->getCnh(),
            'age' => $this->getAge(),
            'status' => $this->getStatus(),
            'courseCoordinated' => $this->getCoordinatedCourse(),
            'academicTitle' => $this->getAcademicTitle(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
        ];
    }
}