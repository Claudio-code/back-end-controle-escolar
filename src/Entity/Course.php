<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course implements JsonSerializable
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
     * @ORM\Column(type="integer", length=255)
     * @Assert\NotBlank(message="o total de horas não pode ser nulo", payload={"severity"="error"})
     * @Assert\Type(type="integer")
     */
    private int $totalAmountHours;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Discipline", inversedBy="courses")
     */
    private $disciplines;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Classes", mappedBy="course")
     */
    private $classes;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Teacher", inversedBy="coordinatedCourse")
     */
    private ?Teacher $coordinator = null;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTotalAmountHours(): ?int
    {
        return $this->totalAmountHours;
    }

    public function setTotalAmountHours(int $totalAmountHours): self
    {
        $this->totalAmountHours = $totalAmountHours;

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

    /**
     * @return ArrayCollection
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline $discipline): void
    {
        $this->disciplines->add($discipline);
    }

    public function setDisciplines(ArrayCollection $disciplines): void
    {
        $this->disciplines = $disciplines;
    }

    /**
     * @return ArrayCollection
     */
    public function getClasses()
    {
        return $this->classes;
    }

    public function addClasse(Classes $classes): void
    {
        $this->classes->add($classes);
    }

    /**
     * @param ArrayCollection $classes
     */
    public function setClasses(ArrayCollection $classes): void
    {
        $this->classes = $classes;
    }

    public function getCoordinator(): ?Teacher
    {
        return $this->coordinator;
    }

    public function setCoordinator(?Teacher $coordinator): void
    {
        $this->coordinator = $coordinator;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'totalAmountHours' => $this->getTotalAmountHours(),
            'coordinator' => $this->getCoordinator(),
            'classes' => $this->getClasses()->toArray(),
            'diciplines' => $this->getDisciplines()->toArray(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
        ];
    }
}
