<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_appointment"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message = "Le champ date ne doit pas être vide")
     * @Groups({"show_appointment"})
     */
    private $appointment_date;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(message = "Le champ heure ne doit pas être vide")
     * @Groups({"show_appointment"})
     */
    private $appointment_time;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Le champ durée ne doit pas être vide")
     * @Groups({"show_appointment"})
     */
    private $appointment_duration;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="appointments")
     * @Groups({"show_appointment"})
     */
    private $appointment_patient;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class, inversedBy="appointments")
     * @Groups({"show_appointment"})
     */
    private $appointment_doctor;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $appointment_take_datetime;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_appointment"})
     */
    private $appointment_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointmentDate(): ?\DateTimeInterface
    {
        return $this->appointment_date;
    }

    public function setAppointmentDate(\DateTimeInterface $appointment_date): self
    {
        $this->appointment_date = $appointment_date;

        return $this;
    }

    public function getAppointmentTime(): ?\DateTimeInterface
    {
        return $this->appointment_time;
    }

    public function setAppointmentTime(\DateTimeInterface $appointment_time): self
    {
        $this->appointment_time = $appointment_time;

        return $this;
    }

    public function getAppointmentDuration(): ?int
    {
        return $this->appointment_duration;
    }

    public function setAppointmentDuration(int $appointment_duration): self
    {
        $this->appointment_duration = $appointment_duration;

        return $this;
    }

    public function getAppointmentPatient(): ?Patient
    {
        return $this->appointment_patient;
    }

    public function setAppointmentPatient(?Patient $appointment_patient): self
    {
        $this->appointment_patient = $appointment_patient;

        return $this;
    }

    public function getAppointmentDoctor(): ?Doctor
    {
        return $this->appointment_doctor;
    }

    public function setAppointmentDoctor(?Doctor $appointment_doctor): self
    {
        $this->appointment_doctor = $appointment_doctor;

        return $this;
    }

    public function getAppointmentTakeDatetime(): ?\DateTimeInterface
    {
        return $this->appointment_take_datetime;
    }

    public function setAppointmentTakeDatetime(?\DateTimeInterface $appointment_take_datetime): self
    {
        $this->appointment_take_datetime = $appointment_take_datetime;

        return $this;
    }

    public function getAppointmentStatus(): ?int
    {
        return $this->appointment_status;
    }

    public function setAppointmentStatus(int $appointment_status): self
    {
        $this->appointment_status = $appointment_status;

        return $this;
    }
}
