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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class TransactionController{


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
            throw new HttpException(403,'Vous n\'avez pas acces à ce comptes !!');
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
       $data->setStatus(false);

       //je retire la somme sur compte emeteur
        if($Userevoi->getRole()->getLibelle()=="ROLE_USER_PARTENAIRE")// Si l'utilisateur est un USER_PARTENAIRE 
        {
       $compte=$Userevoi->getAffectComptes()[0]->getComptes();
        $solde=$compte->getSolde();


          /*verififier si le compte attribuer à l'utilisateur partenaire
           est suffisant pour le montant de transfert demandé*/
        if($montant<$id->getComptes()->getSolde()){
        $compte->setSolde($solde-$montant+$commissionEmeteur);
        }else{
            throw new HttpException(403,'le solde de compte est insufissant pour effectuer cette transaction !!');

        }
        }
        else{
            $compte=$data->getComptesEnv();
             $solde=$compte->getSolde();

              /*verififier si le compte selectionné par  l'admin 
              est suffisant pour le montant de transfert demandé*/
             if($montant<$id->getComptes()->getSolde()){
                $compte->setSolde($solde-$montant+$commissionEmeteur);
            }else{
                throw new HttpException(403,'le solde de compte est insufissant pour effectuer cette transaction !!');
    
            }
        }

        //je verifie si l'utilisateur dans la periode d'utilisation du compte
        if($id->getDatedebut()>$date || $date>$id->getDateFin() ){
        throw new HttpException(403,' periode:Vous n\'avez pas acces à ce comptes !!');
        }
       
       return $data;


    }

  



}
?>