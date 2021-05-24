<?php

namespace App\Entity;

use App\Repository\DoctorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DoctorRepository::class)
 * @UniqueEntity("doctor_phone", message="Le numéro de téléphone est déja utilisé")
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
     * @Groups({"show_doctor"})
     * @Assert\NotBlank(message = "Le champ prénom ne doit pas être vide")
     */
    private $doctor_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_doctor"})
     * @Assert\NotBlank(message = "Le champ nom ne doit pas être vide")
     */
    private $doctor_lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_doctor", "show_appointment"})
     */
    private $doctor_complete_name;    

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @Groups({"show_doctor"})
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_doctor"})
     * @Assert\NotBlank(message = "Le champ date de naissance ne doit pas être vide")
     */
    private $doctor_birth;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_doctor"})
     * @Assert\NotBlank(message = "Le champ téléphone ne doit pas être vide")
     */
    private $doctor_phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_doctor"})
     * @Assert\NotBlank(message = "Le champ adresse ne doit pas être vide")
     */
    private $doctor_place;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_doctor"})
     * @Assert\NotBlank(message = "Le champ ville ne doit pas être vide")
     */
    private $doctor_city;

    /**
     * @ORM\ManyToMany(targetEntity=Domain::class, inversedBy="doctors")
     * @Groups({"show_doctor"})
     * @Assert\NotBlank
     */
    private $doctor_domain_id;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="appointment_doctor")
     */
    private $appointments;

    public function __construct()
    {
        $this->doctor_domain_id = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

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

    public function getDoctorCompleteName(): ?string
    {
        return $this->doctor_complete_name;
    }

    public function setDoctorCompleteName(string $doctor_complete_name): self
    {
        $this->doctor_complete_name = $doctor_complete_name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDoctorBirth(): ?\DateTimeInterface
    {
        return $this->doctor_birth;
    }

    public function setDoctorBirth(\DateTimeInterface $doctor_birth): self
    {
        $this->doctor_birth = $doctor_birth;

        return $this;
    }

    public function getDoctorPhone(): ?string
    {
        return $this->doctor_phone;
    }

    public function setDoctorPhone(string $doctor_phone): self
    {
        $this->doctor_phone = $doctor_phone;

        return $this;
    }

    public function getDoctorPlace(): ?string
    {
        return $this->doctor_place;
    }

    public function setDoctorPlace(string $doctor_place): self
    {
        $this->doctor_place = $doctor_place;

        return $this;
    }

    public function getDoctorCity(): ?string
    {
        return $this->doctor_city;
    }

    public function setDoctorCity(string $doctor_city): self
    {
        $this->doctor_city = $doctor_city;

        return $this;
    }

    /**
     * @return Collection|Domain[]
     */
    public function getDoctorDomainId(): Collection
    {
        return $this->doctor_domain_id;
    }

    public function addDoctorDomainId(Domain $doctorDomainId): self
    {
        if (!$this->doctor_domain_id->contains($doctorDomainId)) {
            $this->doctor_domain_id[] = $doctorDomainId;
        }

        return $this;
    }

    public function removeDoctorDomainId(Domain $doctorDomainId): self
    {
        $this->doctor_domain_id->removeElement($doctorDomainId);

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setAppointmentDoctor($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getAppointmentDoctor() === $this) {
                $appointment->setAppointmentDoctor(null);
            }
        }

        return $this;
    }
}
