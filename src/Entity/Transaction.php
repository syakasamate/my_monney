<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\PartController;
use App\Controller\RetraitController;
use App\Controller\TransactionController;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"read1"}},
 *  denormalizationContext={"groups"={"write1"}},
 * 

 *collectionOperations={
 *               "get"={"method"="GET"},
*          "get_part"={
*          "path"="/transaction/part",
*         "method"="GET",
*        "controller"=PartController::class,
*               },
*               "POST"={ 
*                    "controller"=TransactionController::class,

*                },
*          

*     },
*  itemOperations={
*          "GET"={
*               },
*          "put"={
*             "normalization_context"={"groups"={"read2"}},
 *            "denormalization_context"={"groups"={"write2"}},

 *              "controller"=RetraitController::class,
 *          },
 *     },
*)
* @ApiFilter(SearchFilter::class, properties={"code": "exact"}),
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @UniqueEntity (fields = {"code"}, message = "le code doit être unique")
 *@ApiFilter(DateFilter::class, properties={"dateEnv"})

 * 
 */
class Transaction
{
    /**
     *@Groups({"read1", "write1"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     *@Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255)
     */
    private $telEnv;

    /**
     * @Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255)
     */
    private $montant;

    

    /**
     *@Groups({"read1", "write1"})
     * @ORM\Column(type="date")
     */
    private $dateEnv;

    /**
     * @Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255)
     */
    private $prenomEnv;

    /**
     *@Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nomBenef;

    /**
     *@Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $prenomBenef;

    /**
     *@Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cnibenef;

    /**
     * @Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255)
     */
    private $nomEnv;

    /**
     *@Groups({"read1", "write1"})
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $telBenef;

    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $userEnv;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transaction")
     * ORM \ JoinColumn (nullable = true)
     */
    private $userRet;

    

   

    /**
     *@Groups({"read1"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetret;

   

    /**
     * @ORM\Column(type="integer")
     */
    private $tarifs;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionEmeteur;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionRecepteur;

    /**
     * @ORM\Column(type="integer")
     */
    private $commisionWari;

    /**
     * @ORM\Column(type="integer")
     */
    private $partEtat;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read1", "write1"})
     */
    private $comptesEnv;

   

    /**
     * @Groups({"read1"})
     * @ORM\Column(type="boolean")
     */
    private $status;

    

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transaction")
     *@ORM\JoinColumn(nullable=true)
     * @Groups({"read2", "write2"})
     */
    private $comptesRet;

   

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getTelEnv(): ?string
    {
        return $this->telEnv;
    }

    public function setTelEnv(string $telEnv): self
    {
        $this->telEnv = $telEnv;

        return $this;
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

    public function getDateEnv(): ?\DateTimeInterface
    {
        return $this->dateEnv;
    }

    public function setDateEnv(\DateTimeInterface $dateEnv): self
    {
        $this->dateEnv = $dateEnv;

        return $this;
    }

   

    public function getPrenomEnv(): ?string
    {
        return $this->prenomEnv;
    }

    public function setPrenomEnv(string $prenomEnv): self
    {
        $this->prenomEnv = $prenomEnv;

        return $this;
    }

    public function getNomBenef(): ?string
    {
        return $this->nomBenef;
    }

    public function setNomBenef(string $nomBenef): self
    {
        $this->nomBenef = $nomBenef;

        return $this;
    }

    public function getPrenomBenef(): ?string
    {
        return $this->prenomBenef;
    }

    public function setPrenomBenef(string $prenomBenef): self
    {
        $this->prenomBenef = $prenomBenef;

        return $this;
    }

    public function getCnibenef(): ?string
    {
        return $this->cnibenef;
    }

    public function setCnibenef(?string $cnibenef): self
    {
        $this->cnibenef = $cnibenef;

        return $this;
    }

    public function getNomEnv(): ?string
    {
        return $this->nomEnv;
    }

    public function setNomEnv(string $nomEnv): self
    {
        $this->nomEnv = $nomEnv;

        return $this;
    }

    public function getTelBenef(): ?string
    {
        return $this->telBenef;
    }

    public function setTelBenef(string $telBenef): self
    {
        $this->telBenef = $telBenef;

        return $this;
    }


    public function getUserEnv(): ?User
    {
        return $this->userEnv;
    }

    public function setUserEnv(?User $userEnv): self
    {
        $this->userEnv = $userEnv;

        return $this;
    }

    public function getUserRet(): ?User
    {
        return $this->userRet;
    }

    public function setUserRet(?User $userRet): self
    {
        $this->userRet = $userRet;

        return $this;
    }

   



    public function getDateRetret(): ?\DateTimeInterface
    {
        return $this->dateRetret;
    }

    public function setDateRetret(?\DateTimeInterface $dateRetret): self
    {
        $this->dateRetret = $dateRetret;

        return $this;
    }

  

    public function getTarifs(): ?int
    {
        return $this->tarifs;
    }

    public function setTarifs(int $tarifs): self
    {
        $this->tarifs = $tarifs;

        return $this;
    }

    public function getCommissionEmeteur(): ?int
    {
        return $this->commissionEmeteur;
    }

    public function setCommissionEmeteur(int $commissionEmeteur): self
    {
        $this->commissionEmeteur = $commissionEmeteur;

        return $this;
    }

    public function getCommissionRecepteur(): ?int
    {
        return $this->commissionRecepteur;
    }

    public function setCommissionRecepteur(int $commissionRecepteur): self
    {
        $this->commissionRecepteur = $commissionRecepteur;

        return $this;
    }

    public function getCommisionWari(): ?int
    {
        return $this->commisionWari;
    }

    public function setCommisionWari(int $commisionWari): self
    {
        $this->commisionWari = $commisionWari;

        return $this;
    }

    public function getPartEtat(): ?int
    {
        return $this->partEtat;
    }

    public function setPartEtat(int $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getComptesEnv(): ?Compte
    {
        return $this->comptesEnv;
    }

    public function setComptesEnv(?Compte $comptesEnv): self
    {
        $this->comptesEnv = $comptesEnv;

        return $this;
    }

   

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTransaction(): ?Compte
    {
        return $this->transaction;
    }

    public function setTransaction(?Compte $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getComptesRet(): ?Compte
    {
        return $this->comptesRet;
    }

    public function setComptesRet(?Compte $comptesRet): self
    {
        $this->comptesRet = $comptesRet;

        return $this;
    }

}
