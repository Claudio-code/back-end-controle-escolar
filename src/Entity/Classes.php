<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClassesRepository::class)
 */
class Classes implements JsonSerializable
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
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="o numero de estudantes não pode ser nulo", payload={"severity"="error"})
     * @Assert\Type(type="integer")
     */
    private int $numberStudents;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="o numero maximo de estudantes não pode ser nulo", payload={"severity"="error"})
     * @Assert\Type(type="integer")
     */
    private int $maximumStudents;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="classes")
     */
    private ?Course $course = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Matriculation", mappedBy="classe")
     */
    private $matriculations;

    public function __construct()
    {
        $this->matriculations = new ArrayCollection();
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

    public function getNumberStudents(): ?int
    {
        return $this->numberStudents;
    }

    public function setNumberStudents(int $numberStudents): self
    {
        $this->numberStudents = $numberStudents;

        return $this;
    }

    public function getMaximumStudents(): ?int
    {
        return $this->maximumStudents;
    }

    public function setMaximumStudents(int $maximumStudents): self
    {
        $this->maximumStudents = $maximumStudents;

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     * @param Course|null $course
     */
    public function setCourse(?Course $course): void
    {
        $this->course = $course;
    }

    public function getMatriculations()
    {
        return $this->matriculations;
    }

    public function setMatriculations(ArrayCollection $matriculations): void
    {
        $this->matriculations = $matriculations;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'numberStudents' => $this->getNumberStudents(),
            'maximumStudents' => $this->getMaximumStudents(),
            'course' => $this->getCourse(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
            'matriculations' => $this->getMatriculations()->toArray(),
        ];
    }
}
