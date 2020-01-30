<?php
namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Depot;
use App\Entity\User;
use App\Repository\RolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;
private $repo;
    public function __construct( EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder,TokenStorageInterface $tokenStorage,RolesRepository $repo)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        $this->repo=$repo;
    }

    public function __invoke(Compte $data)
    {
    
        // je crypte le mot de passe du propriaite du compte
       $userPasswor=$this->userPasswordEncoder->encodePassword($data->getPartenaires()->getUsers(), $data->getPartenaires()->getUsers()->getPassword());
       $data->getPartenaires()->getUsers()->SetPassword($userPasswor);

       //j'initialise  le 
       $partenaire=$this->repo->findByLibelle("ROLE_PARTENAIRE");
       $data->getPartenaires()->getUsers()->setRole($partenaire);

        //j'initialise  le solde à 5000 00  l'or de la creation;
        $solde=$data->getDepots()[0]->getMontant();
        if($solde<500000){
        throw new Exception("le montant desposer ne doit pas etre inferieur à 50000");
        }else{

        
        $data->setSolde($solde);


        //j'initialise le user createur ici 
         // $role=$this->repo->findAll()[3]->getLibelle();
          $usercreateur =$this->tokenStorage->getToken()->getUser();
          $data->setUsercreateur($usercreateur);


        return $data;
        }
    } 
}
?>
