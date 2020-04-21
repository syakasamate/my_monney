<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $borneinferieur;

    /**
     * @ORM\Column(type="integer")
     */
    private $borneSuperieur;

    /**
     * @ORM\Column(type="integer")
     */
    private $valeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneinferieur(): ?int
    {
        return $this->borneinferieur;
    }

    public function setBorneinferieur(int $borneinferieur): self
    {
        $this->borneinferieur = $borneinferieur;

        return $this;
    }

    public function getBorneSuperieur(): ?int
    {
        return $this->borneSuperieur;
    }

    public function setBorneSuperieur(int $borneSuperieur): self
    {
        $this->borneSuperieur = $borneSuperieur;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
}
