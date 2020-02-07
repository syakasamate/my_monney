<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Repository\AffectCompteRepository;
use App\Repository\TarifRepository;
use App\Repository\TransactionRepository;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class TransactionController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;



private $validator;
    public function __construct( ValidatorInterface $validator, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder,
    TokenStorageInterface $tokenStorage, TransactionRepository $repo, AffectCompteRepository $afect,TarifRepository $tarifripo)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        $this->repo=$repo;
        $this->afect=$afect;
        $this->tarifripo=$tarifripo;
    }

    public function __invoke(Transaction  $data): Transaction
    {
 
        //je rcuper les fraits
         $i=0;
         $frai=0;
      $tarif =$this->tarifripo->findAll();

      $montant=$data->getMontant();

      for($i==0; $i<count($tarif);$i++){

          $borneSup=$tarif[$i]->getBorneSuperieur();
          $borneInf=$tarif[$i]->getBorneinferieur();
       if($borneInf<=$montant && $borneSup>=$montant){
          if(2000001<=$montant && $montant<=3000000){
                  $frai=$montant*0.02;
          }else{
              $frai=$tarif[$i]->getValeur();
          }
       }
    }
    //je departage les part dans le frait
    $parEtat=$frai*0.4;
    $commissionWari=$frai*0.3;
    $commissionEmeteur=$frai*0.1;
    $commissionRecepteur=$frai*0.2;

    //je recupere l'utilisateur connecter
        $Userevoi =$this->tokenStorage->getToken()->getUser();
        $user=$Userevoi->getId();
     
         $id= $this->afect->user($user);
         if($Userevoi->getRole()->getLibelle()=="ROLE_USER_PARTENAIRE"){// Si l'utilisateur est un USER_PARTENAIRE 
         if($id!=null && $data->getComptesEnv()==null){
          $compte=$id->getComptes();
          $data->setComptesEnv($compte);
         }else{
             throw new Exception("Vous avez aucun droit sur ce compte");
         }
        }
        $data->setUserEnv($Userevoi);
        $numero=$this->repo->numeroAction();
        $data->setCode($numero);

       //j'initialise les fraits 
       $data->setCommissionEmeteur($commissionEmeteur);
       $data->setCommissionRecepteur($commissionRecepteur);
       $data->setCommisionWari($commissionWari);
       $data->setTarifs($frai);
       $data->setPartEtat($parEtat);
       

       //je retire la somme sur compte emeteur
       
        if($Userevoi->getRole()->getLibelle()=="ROLE_USER_PARTENAIRE")// Si l'utilisateur est un USER_PARTENAIRE 
        {
       $compte=$Userevoi->getAffectComptes()[0]->getComptes();
        $solde=$compte->getSolde();
        $compte->setSolde($solde+$montant+$commissionEmeteur);
        }
        else{
            $compte=$data->getComptesEnv();
             $solde=$compte->getSolde();
             $compte->setSolde($solde+$montant+$commissionEmeteur);
        }

        //je regarde si l'utisateur travaille sur son compte
      

       return $data;


    }

  



}
?>