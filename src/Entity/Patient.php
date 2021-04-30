<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 * @UniqueEntity("patient_phone", message="Le numéro de téléphone est déja utilisé")
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_patient"})
     * @Assert\NotBlank(message = "Le champ prénom ne doit pas être vide")
     */
    private $patient_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_patient"})
     * @Assert\NotBlank(message = "Le champ nom ne doit pas être vide")
     */
    private $patient_lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_patient"})
     */
    private $patient_complete_name;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_patient"})
     * @Assert\NotBlank(message = "Le champ date de naissance ne doit pas être vide")
     */
    private $patient_birth;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_patient"})
     * @Assert\NotBlank(message = "Le champ téléphone ne doit pas être vide")
     */
    private $patient_phone;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_patient"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatientName(): ?string
    {
        return $this->patient_name;
    }

    public function setPatientName(string $patient_name): self
    {
        $this->patient_name = $patient_name;

        return $this;
    }

    public function getPatientLastname(): ?string
    {
        return $this->patient_lastname;
    }

    public function setPatientLastname(string $patient_lastname): self
    {
        $this->patient_lastname = $patient_lastname;

        return $this;
    }

    public function getPatientCompleteName(): ?string
    {
        return $this->patient_complete_name;
    }

    public function setPatientCompleteName(string $patient_complete_name): self
    {
        $this->patient_complete_name = $patient_complete_name;

        return $this;
    }

    public function getPatientBirth(): ?\DateTimeInterface
    {
        return $this->patient_birth;
    }

    public function setPatientBirth(\DateTimeInterface $patient_birth): self
    {
        $this->patient_birth = $patient_birth;

        return $this;
    }

    public function getPatientPhone(): ?string
    {
        return $this->patient_phone;
    }

    public function setPatientPhone(string $patient_phone): self
    {
        $this->patient_phone = $patient_phone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
