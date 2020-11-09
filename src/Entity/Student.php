<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 * @ORM\Table(name="students")
 */
class Student implements JsonSerializable
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
     *     message=""
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
     *     message="o sexo não pode ser nulo"
     * )
     * @Assert\Type(type="string")
     */
    private string $sex;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="a etnia não pode ser nulo"
     * )
     * @Assert\Type(type="string")
     */
    private string $ethnicity;

    /**
     * @ORM\Column(type="boolean", length=255)
     */
    private bool $status;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Responsible", mappedBy="student")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="id", referencedColumnName="student_id")
     * })
     */
    private $responsibles;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Address", mappedBy="student")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="id", referencedColumnName="student_id")
     * })
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $updated_at;

    public function __construct()
    {
        $this->responsibles = new ArrayCollection();
        $this->address = new ArrayCollection();
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

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getEthnicity(): ?string
    {
        return $this->ethnicity;
    }

    public function setEthnicity(string $ethnicity): self
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
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

    /**
     * @return ArrayCollection
     */
    public function getResponsibles()
    {
        return $this->responsibles;
    }

    /**
     * @param ArrayCollection $responsibles
     */
    public function setResponsibles(ArrayCollection $responsibles): void
    {
        $this->responsibles = $responsibles;
    }

    /**
     * @return ArrayCollection
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param ArrayCollection $address
     */
    public function setAddress(ArrayCollection $address): void
    {
        $this->address = $address;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'cpf' => $this->getCpf(),
            'cnh' => $this->getCnh(),
            'rg' => $this->getRg(),
            'age' => $this->getAge(),
            'sex' => $this->getSex(),
            'ethnicity' => $this->getEthnicity(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y'),
            'Addresses' => $this->getAddress()->toArray(),
            'Responsibles' => $this->getResponsibles()->toArray(),
        ];
    }
}
