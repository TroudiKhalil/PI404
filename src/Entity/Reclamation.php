<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $telephone = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $cmnt = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?user $id_user = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeReclamation $id_tr = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?doctor $id_doctor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCmnt(): ?string
    {
        return $this->cmnt;
    }

    public function setCmnt(string $cmnt): self
    {
        $this->cmnt = $cmnt;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->id_user;
    }

    public function setIdUser(?user $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdTr(): ?TypeReclamation
    {
        return $this->id_tr;
    }

    public function setIdTr(?TypeReclamation $id_tr): self
    {
        $this->id_tr = $id_tr;

        return $this;
    }

    public function getIdDoctor(): ?doctor
    {
        return $this->id_doctor;
    }

    public function setIdDoctor(?doctor $id_doctor): self
    {
        $this->id_doctor = $id_doctor;

        return $this;
    }
}
