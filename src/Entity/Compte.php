<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\CompteController;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 * @ApiResource(
 *  normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"write"}},
 * collectionOperations={
 *          
 *         "GET"={
*               },
*               "POST"={
*                    "controller"=CompteController::class,

*                }
* 
*     },
*  itemOperations={
*          "GET"={
*                   "access_control"="is_granted('VIEW',  previous_object)",
*               },
*          "put"={
 *              "access_control"="is_granted('EDIT', previous_object)",
 *          },
 *     },
 *  
 * )
 *
 */
class Compte
{
    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

  
    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="date")
     */
    private $datecreation;

   

    /**
     *@Groups({"read", "write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte",cascade={"persist"})
     */
    private $depots;

   

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes",cascade={"persist"})
     *@ApiFilter(SearchFilter::class, properties={"partenaires.ninea":"exact"})
     */
    private $partenaires;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float")
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes")
     */
    private $usercreateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffectCompte", mappedBy="comptes")
     */
    private $affectComptes;

   

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="comptesEnv")
     */
    private $transactions;

    /**
     * @ORM\Column(type="float")
     */
    private $plafond;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="comptesRet")
     */
    private $transaction;

   
   

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->affectComptes = new ArrayCollection();
        $this->transaction = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->datecreation=new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDateCreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

  

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }


    public function getPartenaires(): ?Partenaire
    {
        return $this->partenaires;
    }

    public function setPartenaires(?Partenaire $partenaires): self
    {
        $this->partenaires = $partenaires;

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getUsercreateur(): ?User
    {
        return $this->usercreateur;
    }

    public function setUsercreateur(?User $usercreateur): self
    {
        $this->usercreateur = $usercreateur;

        return $this;
    }

    /**
     * @return Collection|AffectCompte[]
     */
    public function getAffectComptes(): Collection
    {
        return $this->affectComptes;
    }

    public function addAffectCompte(AffectCompte $affectCompte): self
    {
        if (!$this->affectComptes->contains($affectCompte)) {
            $this->affectComptes[] = $affectCompte;
            $affectCompte->setComptes($this);
        }

        return $this;
    }

    public function removeAffectCompte(AffectCompte $affectCompte): self
    {
        if ($this->affectComptes->contains($affectCompte)) {
            $this->affectComptes->removeElement($affectCompte);
            // set the owning side to null (unless already changed)
            if ($affectCompte->getComptes() === $this) {
                $affectCompte->setComptes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setComptesEnv($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getComptesEnv() === $this) {
                $transaction->setComptesEnv(null);
            }
        }

        return $this;
    }

    public function getPlafond(): ?float
    {
        return $this->plafond;
    }

    public function setPlafond(float $plafond): self
    {
        $this->plafond = $plafond;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

  


    
}
