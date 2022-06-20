<?php

namespace App\Entity;

use App\Repository\Identification1Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Identification1Repository::class)
 */
class Identification1
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="identification1s")
     */
    private $acheteur;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="vendeurIdentification")
     */
    private $vendeur;

    /**
     * @ORM\OneToOne(targetEntity=DossierActe::class, inversedBy="identification1", cascade={"persist", "remove"})
     */
    private $dossier;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getAcheteur(): ?Client
    {
        return $this->acheteur;
    }

    public function setAcheteur(?Client $acheteur): self
    {
        $this->acheteur = $acheteur;

        return $this;
    }

    public function getVendeur(): ?Client
    {
        return $this->vendeur;
    }

    public function setVendeur(?Client $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getDossier(): ?DossierActe
    {
        return $this->dossier;
    }

    public function setDossier(?DossierActe $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }
}
