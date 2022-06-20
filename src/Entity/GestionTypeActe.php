<?php

namespace App\Entity;

use App\Repository\GestionTypeActeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GestionTypeActeRepository::class)
 */
class GestionTypeActe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=DocumentTypeActe::class, mappedBy="document",cascade={"persist"})
     */
    private $documentTypeActes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $active;

    public function __construct()
    {
        $this->documentTypeActes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, DocumentTypeActe>
     */
    public function getDocumentTypeActes(): Collection
    {
        return $this->documentTypeActes;
    }

    public function addDocumentTypeActe(DocumentTypeActe $documentTypeActe): self
    {
        if (!$this->documentTypeActes->contains($documentTypeActe)) {
            $this->documentTypeActes[] = $documentTypeActe;
            $documentTypeActe->setDocument($this);
        }

        return $this;
    }

    public function removeDocumentTypeActe(DocumentTypeActe $documentTypeActe): self
    {
        if ($this->documentTypeActes->removeElement($documentTypeActe)) {
            // set the owning side to null (unless already changed)
            if ($documentTypeActe->getDocument() === $this) {
                $documentTypeActe->setDocument(null);
            }
        }

        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }
}
