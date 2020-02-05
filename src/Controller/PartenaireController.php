<?php
namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Partenaire;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PartenaireController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;
    public function __construct( EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder,TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        
    }

    public function __invoke(Partenaire $data)
    {
           //j'initialise  le  Partenire
         /*$usercreateur =$this->tokenStorage->getToken()->getRoles();
           $data->getUsers()[0]->;*/   
        return $data;
    }
}
?>