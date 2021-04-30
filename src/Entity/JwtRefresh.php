<?php

namespace App\Entity;

use App\Repository\JwtRefreshRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JwtRefreshRepository::class)
 */
class JwtRefresh
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=650)
     */
    private $jwtrefresh_value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $jwtrefresh_date_issued;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJwtrefreshValue(): ?string
    {
        return $this->jwtrefresh_value;
    }

    public function setJwtrefreshValue(string $jwtrefresh_value): self
    {
        $this->jwtrefresh_value = $jwtrefresh_value;

        return $this;
    }

    public function getJwtrefreshDateIssued(): ?\DateTimeInterface
    {
        return $this->jwtrefresh_date_issued;
    }

    public function setJwtrefreshDateIssued(\DateTimeInterface $jwtrefresh_date_issued): self
    {
        $this->jwtrefresh_date_issued = $jwtrefresh_date_issued;

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
}
