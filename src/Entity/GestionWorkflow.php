<?php

namespace App\Entity;

use App\Repository\GestionWorkflowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GestionWorkflowRepository::class)
 */
class GestionWorkflow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Workflow::class, mappedBy="gestionWorkflow",cascade={"persist"})
     */
    private $workflow;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $active;

    public function __construct()
    {
        $this->workflow = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Workflow>
     */
    public function getWorkflow(): Collection
    {
        return $this->workflow;
    }

    public function addWorkflow(Workflow $workflow): self
    {
        if (!$this->workflow->contains($workflow)) {
            $this->workflow[] = $workflow;
            $workflow->setGestionWorkflow($this);
        }

        return $this;
    }

    public function removeWorkflow(Workflow $workflow): self
    {
        if ($this->workflow->removeElement($workflow)) {
            // set the owning side to null (unless already changed)
            if ($workflow->getGestionWorkflow() === $this) {
                $workflow->setGestionWorkflow(null);
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
