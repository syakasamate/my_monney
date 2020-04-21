<?php
namespace App\Controller;

use Osms\Osms;
use Twilio\Rest\Client;

    use Exception;
    use App\Entity\User;
    use App\Entity\Transaction;
    use App\Repository\TarifRepository;
    use App\Repository\TransactionRepository;
    use App\Repository\AffectCompteRepository;
    use DateTime;
    use PhpParser\Node\Stmt\ElseIf_;
    use Symfony\Component\HttpKernel\Exception\HttpException;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


    class TransactionController{

    const ROLE_U_P="ROLE_USER_PARTENAIRE";
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



    //JE CALCULE LES LES FRAITS
        $i=0;$frai=0;
        $tarif =$this->tarifripo->findAll();
        $montant=$data->getMontant();



        for($i==0; $i<count($tarif);$i++){
            $borneSup=$tarif[$i]->getBorneSuperieur();
            $borneInf=$tarif[$i]->getBorneinferieur();
        if($borneInf<=$montant && $borneSup>=$montant){
            if(2000001<=$montant && $montant<=3000000){
                    $frai=$montant*0.02;
                    $montantnet=$montant-$frai();
            }else{
                $frai=$tarif[$i]->getValeur();
                $montantnet=$montant-$tarif[$i]->getValeur();

            }
        }
        }

            //JE  DEPARTAGE LES PARTS DANS LES FRAITS
            $parEtat=$frai*0.4;
            $commissionWari=$frai*0.3;
            $commissionEmeteur=$frai*0.1;
            $commissionRecepteur=$frai*0.2;


        //JE RECUPERE L'UTILISATEUR CONNECTÉ
            $Userevoi =$this->tokenStorage->getToken()->getUser();
            $user=$Userevoi->getId();
            $id= $this->afect->user($user);

            // SI C'EST UN  USER_PARTENAIRE
            if($Userevoi->getRole()->getLibelle()==self::ROLE_U_P){
            if($id!=null && $data->getComptesEnv()==null){
            $compte=$id->getComptes();
            $data->setComptesEnv($compte);
            }else{
                throw new HttpException(403,'Vous n\'avez pas acces à ce comptes !!');
            }
            }

            //J'INITIALISE LE USER EMETEUR 
            $data->setUserEnv($Userevoi);
            
            //J'INIALISE LE CODE DE TRANSFERT
            $numero=$this->repo->numeroAction();
            $data->setCode($numero);

        //J'INITIALISE LES PARTS 
        $data->setCommissionEmeteur($commissionEmeteur);
        $data->setCommissionRecepteur($commissionRecepteur);
        $data->setCommisionWari($commissionWari);
        $data->setTarifs($frai);
        $data->setPartEtat($parEtat);

        //J'INITIALISE L'ETAT DE TRANSACTION A FALSE L'OR DE L'ENVOI
        $data->setStatus(false);
            
        //JE RECUPERE LA DATE DU SYSTEME ET JE L'ILINIALISE PAR LA DE DATE D'ENVOI DE TRANSACTION
            $date=new DateTime();
            $data->setDateEnv($date);


        /*JE TESTE SI L'UTILISATEUR CONNECTÉ EST UN  USER_PARTENAIRE
            JE RECUPERE LES LE SOLDE DU COMPTE QU'IL EST AFFECTÉ */
            if($Userevoi->getRole()->getLibelle()==self::ROLE_U_P)
            {
        $compte=$Userevoi->getAffectComptes()[0]->getComptes();
            $solde=$compte->getSolde();


            /*verififier si le compte attribuer à l'utilisateur partenaire
            est suffisant pour le montant de transfert demandé */
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
                if($montant<$data->getComptesEnv()->getSolde()){
                    $compte->setSolde($solde-$montant+$commissionEmeteur);
                }else{
                    throw new HttpException(403,'le solde de compte est insufissant pour effectuer cette transaction !!');
        
                }
            }

            //je verifie si l'utilisateur est  dans la periode d'utilisation du compte
          /*  if($Userevoi->getRole()->getLibelle()=="ROLE_USER_PARTENAIRE"){

            if($id->getDatedebut()>$date || $date>$id->getDateFin()){
            throw new HttpException(403,'Impossible d\'utiliser Ce compte Veillez vous reprocher de votre administrateur  !!');
            }
        }*/

        
       /* $sid = 'ACc6001f892c25ee63332579146b8f707e';
        $token = 'de24f89a620b9d18cb16d92494d69565';
        $client = new Client($sid, $token);
        // Use the client to do fun stuff like send text messages!
        $numero='+13852904230';
        $client->messages->create(
            // the number you'd like to send the message to
     
             '+221'.$data->getTelBenef(),
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $numero,
                // the body of the text message you'd like to send
                'body' => ' Bienvenu sur Kodo TRansfert'.$data->getNomEnv().'Vient de vous envoyé'.$montantnet.'le code est'.
                $data->getCode()
            )
        );
*/
                  
    //$this->repo->sendMessage($data->getTelEnv(), $data->getTelBenef(),$data->getNomEnv(),$montantnet,$data->getCode());
        return $data;


        }

    



    }
?>