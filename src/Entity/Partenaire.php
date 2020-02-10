<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\PartenaireController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 * @ApiResource(
 * normalizationContext={"groups"={"read"}},
 *denormalizationContext={"groups"={"write"}},
   
 *  collectionOperations={
 * 
 *          
 *         "GET"={
 *               "access_control"="is_granted('VIEW', object)",

*               },
*               "POST"={
*                    "controller"=PartenaireController::class,

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
 */
class Partenaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $ninea;

    /**    
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $rc;

    /**
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="partenaires",cascade={"persist"})
     */
    private $comptes;

    /**
     * @Groups({"read", "write"})
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="partenaire",cascade={"persist"})
     */
    private $users;

    /**@Groups({"read", "write"})
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", cascade={"persist", "remove"})
     */
    private $contrat;


    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getRc(): ?string
    {
        return $this->rc;
    }

    public function setRc(string $rc): self
    {
        $this->rc = $rc;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setPartenaires($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getPartenaires() === $this) {
                $compte->setPartenaires(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPartenaire($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPartenaire() === $this) {
                $user->setPartenaire(null);
            }
        }

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

   

    }

  

    

  

    
    

    


