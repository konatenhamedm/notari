<?php

namespace App\Entity;

use App\Repository\DocumentTypeActeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentTypeActeRepository::class)
 */
class DocumentTypeActe
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
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="documentTypeActes")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=GestionTypeActe::class, inversedBy="documentTypeActes")
     */
    private $document;



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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDocument(): ?GestionTypeActe
    {
        return $this->document;
    }

    public function setDocument(?GestionTypeActe $document): self
    {
        $this->document = $document;

        return $this;
    }

}
