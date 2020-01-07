<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 *
 *
 * @ApiResource(
*   collectionOperations={
*      "get"={"security"="is_granted(['ROLE_SUPER_ADMIN'])",
*       "normalization_context"={"groups"={"user"}},
*},
*       "createAdmin"={
*              "method"="POST",
*               "path"="users/admin/create",
*              "security"="is_granted('ROLE_SUPER_ADMIN')",
 *             "security_message"="Acces non autorisé seul le Super admin  peut accéder"
 *         },
 * 
 *    "createCaissier"={
*              "method"="POST",
*               "path"="users/Caissier/create",
*              "security"="is_granted(['ROLE_SUPER_ADMIN','ROLE_ADMIN'])",
 *             "security_message"="Acces non autorisé seul le Super admin et l'admin peut accéder"
 *         },
 * 
 * 
 *   
 * },
 *  itemOperations={
 * 
 * }
 * 
* )
 *  
 *    
 * 
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * 
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 
     *@Groups({"user"}) 
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     *@Groups({"user"})
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Groups({"user"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    

    /**
     * @Groups({"user"})
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @Groups({"user"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles", inversedBy="users")
     */
    private $role;

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
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
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
    public function isAccountNonExpired(){
        return true;   
    }
    public function isAccountNonLocked(){
        return true;
    }
    public function isCredentialsNonExpired(){
        return true;
    }
    public function isEnabled(){
        return $this->isActive;
    }


}
