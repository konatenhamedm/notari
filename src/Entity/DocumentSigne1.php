<?php

namespace App\Entity;

use App\Repository\DocumentSigne1Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentSigne1Repository::class)
 */
class DocumentSigne1
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
     * @ORM\OneToOne(targetEntity=DossierActe::class, inversedBy="documentSigne1", cascade={"persist", "remove"})
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
