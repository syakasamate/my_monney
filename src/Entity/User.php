<?php

namespace App\Entity;

use App\Entity\Partenaire;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\UserController;
use App\Controller\CompteController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;


/** 
 *
 *
 * @ApiResource(
 *  collectionOperations={
 *          
 *         "GET"={
 *               "access_control"="is_granted('VIEW', object)",

*               },
*               "POST"={
 *                  "access_control"="is_granted('ADD', object)",
*                    "controller"=UserController::class,

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
      * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="usercreateur")
      */
     private $comptes;

     

    
   

   




    public function __construct()
    {
        $this->usercreateur = new ArrayCollection();
        $this->comptes = new ArrayCollection();
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

   
   

   

    



   

    
}
