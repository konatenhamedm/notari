<?php

namespace App\Entity;

use App\Repository\EnregistrementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnregistrementRepository::class)
 */
class Enregistrement
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
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroEnregistrement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateRetour;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=Dossier::class, inversedBy="enregistrements")
     */
    private $dossier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNumeroEnregistrement(): ?string
    {
        return $this->numeroEnregistrement;
    }

    public function setNumeroEnregistrement(string $numeroEnregistrement): self
    {
        $this->numeroEnregistrement = $numeroEnregistrement;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getDateRetour(): ?string
    {
        return $this->dateRetour;
    }

    public function setDateRetour(?string $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath($path): self
    {
        if (!is_null($path)){
            $this->path = $path;
        }

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }
}
