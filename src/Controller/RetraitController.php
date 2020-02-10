<?php
namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Transaction;
use App\Repository\TarifRepository;
use App\Repository\TransactionRepository;
use App\Repository\AffectCompteRepository;
use DateTime;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class RetraitController{


const ROLE_U_P='ROLE_USER_PARTENAIRE';
protected $tokenStorage;

    public function __construct(  TokenStorageInterface $tokenStorage, TransactionRepository $repo, AffectCompteRepository $afect,TarifRepository $tarifripo,TransactionRepository $trans)
    {
        
        $this->tokenStorage = $tokenStorage;
        $this->repo=$repo;
        $this->afect=$afect;
        $this->tarifripo=$tarifripo;
        $this->trans=$trans;
    }

    public function __invoke(Transaction  $data): Transaction
    {
    
        $date=new DateTime();
        $dateR=new DateTime();
        
        
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


    //je retire la part du recepteur
    $commissionRecepteur=$frai*0.2;


    //je recupere l'utilisateur connecter
        $Userevoi =$this->tokenStorage->getToken()->getUser();
        $user=$Userevoi->getId();
         $id= $this->afect->user($user);

         if($Userevoi->getRole()->getLibelle()==self::ROLE_U_P){
                  // Si l'utilisateur est un USER_PARTENAIRE
         if($id!=null){
          $compte=$id->getComptes();
          $data->setComptesRet($compte);
         }else{
            throw new HttpException(403,'Vous n\'avez pas acces à ce comptes !!!');
         }
        }
        $data->setUserRet($Userevoi);

       //j'initialise les fraits 
       $data->setCommissionRecepteur($commissionRecepteur);
       $data->setStatus(true);
    
       //j'additionne  la somme sur compte emeteur
        if($Userevoi->getRole()->getLibelle()==self::ROLE_U_P)// Si l'utilisateur est un USER_PARTENAIRE 
        {
       $compte=$Userevoi->getAffectComptes()[0]->getComptes();
        $solde=$compte->getSolde();
        $compte->setSolde($solde+$montant+$commissionRecepteur);
        }
        else{
            $compte=$data->getComptesRet();
             $solde=$compte->getSolde();
             $compte->setSolde($solde-$montant+$commissionRecepteur);
        }

        //je verifie si l'utilisateur dans la periode d'utilisation du compte
        if($Userevoi->getRole()->getLibelle()==self::ROLE_U_P){
       if($id->getDatedebut()>$date || $date>$id->getDateFin() ){
        throw new HttpException(403,' periode:Vous n\'avez pas acces à ce comptes !!');
       }
    }
       $data->setDateRetret($dateR);


      //imposible de faire plus d'un retrait sur le meme compte
     if($data->getStatus()){
        throw new HttpException(403,' Ce retriat est dejas effectuer !!');
     }
       
      
    return $data;
    }

  



}
?>