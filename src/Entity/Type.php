<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Workflow::class, mappedBy="typeActe")
     */
    private $workflows;

    /**
     * @ORM\OneToMany(targetEntity=Acte::class, mappedBy="typeActe")
     */
    private $actes;

    /**
     * @ORM\OneToMany(targetEntity=Dossier::class, mappedBy="typeActe")
     */
    private $dossiers;

    /**
     * @ORM\OneToMany(targetEntity=GestionWorkflow::class, mappedBy="type")
     */
    private $gestionWorkflows;

    public function __construct()
    {
        $this->actes = new ArrayCollection();
        $this->workflows = new ArrayCollection();
        $this->dossiers = new ArrayCollection();
        $this->gestionWorkflows = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    /**
     * @return Collection<int, Workflow>
     */
    public function getWorkflows(): Collection
    {
        return $this->workflows;
    }

    public function addWorkflow(Workflow $workflow): self
    {
        if (!$this->workflows->contains($workflow)) {
            $this->workflows[] = $workflow;
            $workflow->setTypeActe($this);
        }

        return $this;
    }

    public function removeWorkflow(Workflow $workflow): self
    {
        if ($this->workflows->removeElement($workflow)) {
            // set the owning side to null (unless already changed)
            if ($workflow->getTypeActe() === $this) {
                $workflow->setTypeActe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Acte>
     */
    public function getActes(): Collection
    {
        return $this->actes;
    }

    public function addActe(Acte $acte): self
    {
        if (!$this->actes->contains($acte)) {
            $this->actes[] = $acte;
            $acte->setTypeActe($this);
        }

        return $this;
    }

    public function removeActe(Acte $acte): self
    {
        if ($this->actes->removeElement($acte)) {
            // set the owning side to null (unless already changed)
            if ($acte->getTypeActe() === $this) {
                $acte->setTypeActe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dossier>
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setTypeActe($this);
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossiers->removeElement($dossier)) {
            // set the owning side to null (unless already changed)
            if ($dossier->getTypeActe() === $this) {
                $dossier->setTypeActe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GestionWorkflow>
     */
    public function getGestionWorkflows(): Collection
    {
        return $this->gestionWorkflows;
    }

    public function addGestionWorkflow(GestionWorkflow $gestionWorkflow): self
    {
        if (!$this->gestionWorkflows->contains($gestionWorkflow)) {
            $this->gestionWorkflows[] = $gestionWorkflow;
            $gestionWorkflow->setType($this);
        }

        return $this;
    }

    public function removeGestionWorkflow(GestionWorkflow $gestionWorkflow): self
    {
        if ($this->gestionWorkflows->removeElement($gestionWorkflow)) {
            // set the owning side to null (unless already changed)
            if ($gestionWorkflow->getType() === $this) {
                $gestionWorkflow->setType(null);
            }
        }

        return $this;
    }

}
