<?php
namespace App\Controller;

use VARIANT;
use Exception;
use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Repository\ContratRepository;
use App\Repository\RolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;
private $repo;
    public function __construct( EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder
    ,TokenStorageInterface $tokenStorage,RolesRepository $repo, ContratRepository $contrat)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        $this->repo=$repo;
        $this->contrat=$contrat;
    }

    public function __invoke(Compte $data)
    {

        ##########CONTROLLER CREATION DE COMPTE################
                     ###KODO TRANSFERT###

       //POUR LE NOUVEAU PARTENAIRE
         if($data->getPartenaires()!=null){
        //JE CRYPTE LE MOT DE PASSE 
       $userPasswor=$this->userPasswordEncoder->encodePassword($data->getPartenaires()->getUsers()[0],
        $data->getPartenaires()->getUsers()[0]->getPassword());
       $data->getPartenaires()->getUsers()[0]->SetPassword($userPasswor);
         
       //J'INITIALISE LE  PARTENAIRE
       $partenaire=$this->repo->findByLibelle("ROLE_PARTENAIRE");
       $data->getPartenaires()->getUsers()[0]->setRole($partenaire);
         }


        //J'INITIALISE LE  CONTRANT
        $contrat1=$this->contrat->find(1);
      // $data->getPartenaires()->setContrat($contrat1);
         
        //j'initialise  le solde à 5000 00  l'or de la creation
        $solde=$data->getDepots()[0]->getMontant();
        if($solde<500000){
        throw new Exception("le montant à deposer ne doit pas etre inferieur à 50000");
        }else{

          //J'INITIALISE LE SOLDE DU COMPTE
        $data->setSolde($solde);


        //J'INITILISE LE USER_CREATEUR 
          $usercreateur =$this->tokenStorage->getToken()->getUser();
          $data->setUsercreateur($usercreateur);
          $data->setNumero( date ( 'y' ). date ( 'm' ). '' . date ( 'd' ). date ( 'H' ). '' . date ( 'i' ). date ( ' s ' ));
         $data->setPlafond($solde);
        
        
          return $data;
        }
    } 
}

?>
