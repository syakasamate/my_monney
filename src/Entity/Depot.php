<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\DepotController;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 * @ApiResource(
 * collectionOperations={
 *         "GET"={
 *               "access_control"="is_granted('VIEW', object)",

*               },
*               "POST"={
 *                  "access_control"="is_granted('ADD', object)",

*                }
* 
*     },
*  itemOperations={
*          "GET"={
*                "access_control"="is_granted('VIEW',  previous_object)",
*               },
*          "put"={
 *              "access_control"="is_granted('EDIT', previous_object)",
 *          },
 *     },
 * )
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $montant;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots",cascade={"persist"})
     */
    private $compte;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_depot;




    public function __construct()
    {
        $this->date_depot = new DateTime(); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

   

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->date_depot;
    }

    public function setDateDepot(\DateTimeInterface $date_depot): self
    {
        $this->date_depot = $date_depot;

        return $this;
    }

   
    

  

   

  
}
