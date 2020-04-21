<?php

namespace App\Entity;

use App\Entity\Partenaire;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\UserController;
use App\Controller\ImageController;
use App\Controller\CompteController;
use App\Controller\listeAController;
use App\Controller\BloquerController;
use App\Controller\getUserController;
use App\Controller\listeUserController;
use App\Controller\getOneUserController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/** 
 * 
 * @ApiResource(

 *  collectionOperations={
 *  "listeUser"={
 *         "method"="GET",
 *         "path"="/listeUser",
 *          "controller"=listeUserController::class,
 *           "normalization_context"={"groups"={"write"}},
 * },
 *         "post_image"={
 *         "method"="POST",
 *         "path"="/users/{id}",
 *          "controller"=ImageController::class,
 *          "normalization_context"={"groups"={"write"}},
  *              "deserialize"=false,
 *             "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }

 * 
 *     },
 *
 * 
 *         "GET"={
 *              
  *                    "controller"=getUserController::class,                
*               },
*               "POST"={
*                   "controller"=UserController::class,
*   
*                }
* 
*     },
*  itemOperations={
  *   "bloquer"={
 *         "method"="PUT",
 *         "path"="/bloquerusers/{id}",
 *          "controller"=BloquerController::class,
 *           "normalization_context"={"groups"={"write"}},
 * },
*          "GET"={
*                    "controller"=getOneUserController::class,                
*               },
*          
*          "put"={
*       "normalization_context"={"groups"={"write"}},
*       }
 *     },
 *  
 * )
 *  
 *    
 * 
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"username"},
 * 
 *     message="ce eamil est dejas utiliser.")
 * 
 */
class User implements UserInterface  
{
    /**
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     */
      private $id;
    /**
     * 
     * @Groups({"read", "write"}) 
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     * Assert\NotBlank(message="le username ne peut pas etre vide")
     */
      private $username;

    /**
     * 
     * @ORM\Column(type="json")
     */
     private $roles = [];

    /**
     *  @Groups({"read", "write"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     *@Assert\Length(min="8", minMessage="le  mode de pass de doit etre superrieur à 8 caractere")
     */
     private $password;

    /**
     *  @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     */
     private $isActive;

    /**
     *  @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles", inversedBy="users")
     */
     private $role;
    /**
     *  @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
     private $Nom;

    
     
     

     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
      */
     private $partenaire;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="usercreateur")
      */
     private $comptes;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\AffectCompte", mappedBy="users")
      */
     private $affectComptes;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userEnv")
      */
     private $transactions;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userRet")
      */
     private $transaction;
    

     /**
      * 
      * @ORM\Column(name="image",type="blob",nullable=true)
      */
     private $image;
    
     private $decodedData;
    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->affectComptes = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->transaction = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
       return[ $this->role->getLibelle()];
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

   

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
    

    public function getRole(): ?Roles
    {
        return $this->role;
    }

    public function setRole(?Roles $role): self
    {
        $this->role = $role;

        return $this;
    }
   
    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    


    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

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
            $compte->setUsercreateur($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getUsercreateur() === $this) {
                $compte->setUsercreateur(null);
            }
        }

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
            $affectCompte->setUsers($this);
        }

        return $this;
    }

    public function removeAffectCompte(AffectCompte $affectCompte): self
    {
        if ($this->affectComptes->contains($affectCompte)) {
            $this->affectComptes->removeElement($affectCompte);
            // set the owning side to null (unless already changed)
            if ($affectCompte->getUsers() === $this) {
                $affectCompte->setUsers(null);
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
            $transaction->setUserEnv($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getUserEnv() === $this) {
                $transaction->setUserEnv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;
        $this->decodedData = base64_decode($image);

        return $this;
    }

   

  

  

    
}
