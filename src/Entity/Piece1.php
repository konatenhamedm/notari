<?php

namespace App\Entity;

use App\Repository\Piece1Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Piece1Repository::class)
 */
class Piece1
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
    private $libelle;

    /**
     * @ORM\OneToOne(targetEntity=DossierActe::class, inversedBy="piece1", cascade={"persist", "remove"})
     */
    private $dossier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
