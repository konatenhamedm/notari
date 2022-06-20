<?php

namespace App\Entity;

use App\Repository\DossierActeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DossierActeRepository::class)
 */
class DossierActe
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
    private $numeroOuverture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroClassification;

    /**
     * @ORM\OneToOne(targetEntity=Identification1::class, mappedBy="dossier", cascade={"persist", "remove"})
     */
    private $identification1;

    /**
     * @ORM\OneToOne(targetEntity=Piece1::class, mappedBy="dossier", cascade={"persist", "remove"})
     */
    private $piece1;

    /**
     * @ORM\OneToOne(targetEntity=DocumentSigne1::class, mappedBy="dossier", cascade={"persist", "remove"})
     */
    private $documentSigne1;

    /**
     * @ORM\OneToOne(targetEntity=Enregistrement1::class, mappedBy="dossier", cascade={"persist", "remove"})
     */
    private $enregistrement1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroOuverture(): ?string
    {
        return $this->numeroOuverture;
    }

    public function setNumeroOuverture(string $numeroOuverture): self
    {
        $this->numeroOuverture = $numeroOuverture;

        return $this;
    }

    public function getNumeroClassification(): ?string
    {
        return $this->numeroClassification;
    }

    public function setNumeroClassification(string $numeroClassification): self
    {
        $this->numeroClassification = $numeroClassification;

        return $this;
    }

    public function getIdentification1(): ?Identification1
    {
        return $this->identification1;
    }

    public function setIdentification1(?Identification1 $identification1): self
    {
        // unset the owning side of the relation if necessary
        if ($identification1 === null && $this->identification1 !== null) {
            $this->identification1->setDossier(null);
        }

        // set the owning side of the relation if necessary
        if ($identification1 !== null && $identification1->getDossier() !== $this) {
            $identification1->setDossier($this);
        }

        $this->identification1 = $identification1;

        return $this;
    }

    public function getPiece1(): ?Piece1
    {
        return $this->piece1;
    }

    public function setPiece1(?Piece1 $piece1): self
    {
        // unset the owning side of the relation if necessary
        if ($piece1 === null && $this->piece1 !== null) {
            $this->piece1->setDossier(null);
        }

        // set the owning side of the relation if necessary
        if ($piece1 !== null && $piece1->getDossier() !== $this) {
            $piece1->setDossier($this);
        }

        $this->piece1 = $piece1;

        return $this;
    }

    public function getDocumentSigne1(): ?DocumentSigne1
    {
        return $this->documentSigne1;
    }

    public function setDocumentSigne1(?DocumentSigne1 $documentSigne1): self
    {
        // unset the owning side of the relation if necessary
        if ($documentSigne1 === null && $this->documentSigne1 !== null) {
            $this->documentSigne1->setDossier(null);
        }

        // set the owning side of the relation if necessary
        if ($documentSigne1 !== null && $documentSigne1->getDossier() !== $this) {
            $documentSigne1->setDossier($this);
        }

        $this->documentSigne1 = $documentSigne1;

        return $this;
    }

    public function getEnregistrement1(): ?Enregistrement1
    {
        return $this->enregistrement1;
    }

    public function setEnregistrement1(?Enregistrement1 $enregistrement1): self
    {
        // unset the owning side of the relation if necessary
        if ($enregistrement1 === null && $this->enregistrement1 !== null) {
            $this->enregistrement1->setDossier(null);
        }

        // set the owning side of the relation if necessary
        if ($enregistrement1 !== null && $enregistrement1->getDossier() !== $this) {
            $enregistrement1->setDossier($this);
        }

        $this->enregistrement1 = $enregistrement1;

        return $this;
    }
}
