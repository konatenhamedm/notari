<?php

/**
 * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="acheteur")
 */
private $acheteur;

public function getAcheteur(): ?Client
{
    return $this->acheteur;
}

public function setAcheteur(?Client $acheteur): self
{
    $this->acheteur = $acheteur;

    return $this;
}