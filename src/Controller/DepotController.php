<?php
namespace App\Controller;

use App\Entity\Depot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DepotController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;
    public function __construct( EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder,TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        
    }

    public function __invoke(Depot $data)
    {

        ##########CONTROLLER CREATION DE COMPTE################
                     ###KODO TRANSFERT###





       //Je Recupere le Montant à Deposer
        $montant=$data->getMontant();

        //Je Recupere le solde de compte dans lequel on feras le depot
        $montantCmopte=$data->getCompte()->getSolde();
        $plafond=$data->getCompte()->getPlafond();

        
        //J'ajout au solde le montant à deposer
        $somtotal=$montant+$montantCmopte;
         $plafondtotal=$montant+$plafond;
        $data->getCompte()->SetSolde($somtotal);  
        $data->getCompte()->getPlafond($plafondtotal);
        return $data;
    }
}
?>