<?php

namespace App\Entity;

use App\Repository\RemiseActeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RemiseActeRepository::class)
 */
class RemiseActe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=Dossier::class, inversedBy="remiseActes")
     */
    private $dossier;

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
