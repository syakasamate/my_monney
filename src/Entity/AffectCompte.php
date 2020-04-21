<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\AffectCompteController;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 * collectionOperations={
 *         "GET"={

*               },
*               "POST"={
 *                  "access_control"="is_granted('ADD', object)",
 *                  "controller"=AffectCompteController::class,

*                }
* 
*     },
*  itemOperations={
*          "GET"={
*               },
*          "put"={
 *              "access_control"="is_granted('EDIT', previous_object)",
 *          },
 *     },)
 * @ORM\Entity(repositoryClass="App\Repository\AffectCompteRepository")
 */
class AffectCompte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="affectComptes")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="affectComptes")
     */
    private $comptes;

    public function __construct()
    {
        $this->date_debut=new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getComptes(): ?Compte
    {
        return $this->comptes;
    }

    public function setComptes(?Compte $comptes): self
    {
        $this->comptes = $comptes;

        return $this;
    }
}
