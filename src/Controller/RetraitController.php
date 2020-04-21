<?php
namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\User;
use Twilio\Rest\Client;
use App\Entity\Transaction;
use App\Repository\TarifRepository;
use App\Repository\TransactionRepository;
use App\Repository\AffectCompteRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
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

         ##########CONTROLLER  DE TRANSACTION################
                    ###KODO TRANSFERT###
      

                    $dateR=new DateTime();
                  $da=$data->setDateRetret($dateR);
          
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

      //J'initialise le User Recepteur
        $data->setUserRet($Userevoi);

        

      //JE TESTE SI LA TRANSACTION N'EST PAS RETIRER
       if($data->getStatus()==1){
         throw new HttpException(403,' Ce retriat est dejas effectuer !!');
      }

        //J'INITIALIALISE  L'ETAT A TRUE APRES LE RETRAIT
        $data->setStatus(true);

         
           //Je recupere le montant et la commission de recepteur
          $montant=$data->getMontant();
          $commissionRecepteur=$data->getCommissionRecepteur() ;


         /*JE teste si l'utilisateur connecté est un USER_PARTENAIRE
          apres J'aditionne sur son compte le montant retiré plus sa part */
        if($Userevoi->getRole()->getLibelle()==self::ROLE_U_P){
       $compte=$Userevoi->getAffectComptes()[0]->getComptes();
        $solde=$compte->getSolde();
         $plafond1=$compte->getPlafond();
         if($solde+$montant==0){
          throw new HttpException(403,'Votre compte est plafonné à '.$plafond1.'fcf');
         }elseif($solde<$montant){
          throw new HttpException(403,'Votre comptes est Insuffisant pour effectuer cette Transaction');
         }
        $compte->setSolde($solde+$montant);
        }
        else{
            //Au contraire J'aditionne sur son compte  selectionné le montant retiré plus sa part
            $compte=$data->getComptesRet();

             $solde=$compte->getSolde();
            $plafond=$compte->getPlafond();
             if($solde+$montant==0){
              throw new HttpException(403,'Votre compte est plafonné à '.$plafond.'fcf');
             }
             elseif($solde<$montant){
              throw new HttpException(403,'Votre comptes est Insuffisant pour effectuer cette Transaction');

             }
             $compte->setSolde($solde+$montant);
        }

        //je verifie si l'utilisateur dans la periode d'utilisation du compte
        $date=new DateTime();
        /*if($Userevoi->getRole()->getLibelle()==self::ROLE_U_P){
       if($id->getDatedebut()>$date || $date>$id->getDateFin() ){
        throw new HttpException(403,' periode:Vous n\'avez pas acces à ce comptes !!');
       }
    }*/
    //Je Recupere la date du systeme pour initialiser la date du retrait
       


     
        
       /*$sid = 'ACc6001f892c25ee63332579146b8f707e';
       $token = 'de24f89a620b9d18cb16d92494d69565';
       $client = new Client($sid, $token);
       // Use the client to do fun stuff like send text messages!
       $numero='+13852904230';
       $client->messages->create(
           // the number you'd like to send the message to
    
            '+221'.$data->getTelEnv(),
           array(
               // A Twilio phone number you purchased at twilio.com/console
               'from' => $numero,
               // the body of the text message you'd like to send
               'body' => ' Bienvenu sur Kodo TRansfert les '.$data->getMontant().'Envoyer  à '.$data->getNomBenef().'vient d\'etre retiré'
           )
       );*/


     //  $this->repo->recevMessage($data->getTelEnv(), $data->getTelBenef(),$data->getPrenomBenef(),$data->getMontant());
    return $data;
    
    
    }

  

}
?>