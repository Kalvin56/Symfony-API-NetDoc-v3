<?php

namespace App\Entity;

use App\Repository\DoctorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctorRepository::class)
 */
class Doctor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $doctor_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $doctor_lastname;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoctorName(): ?string
    {
        return $this->doctor_name;
    }

    public function setDoctorName(string $doctor_name): self
    {
        $this->doctor_name = $doctor_name;

        return $this;
    }

    public function getDoctorLastname(): ?string
    {
        return $this->doctor_lastname;
    }

    public function setDoctorLastname(string $doctor_lastname): self
    {
        $this->doctor_lastname = $doctor_lastname;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
