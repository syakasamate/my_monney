<?php
namespace App\Controller;

use App\Entity\AffectCompte;
use App\Repository\AffectCompteRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AffectCompteController{
    const ROLE_U_P='ROLE_SUPER_ADMIN';
    const ROLE_A='ROLE_ADMIN';
    const ROLE_C='ROLE_CAISSIER';
    const ROLE_P='ROLE_PARTENAIRE';
    const ROLE_P_A='ROLE_ADMIN_PARTENAIRE';
protected $tokenStorage;
    public function __construct( TokenStorageInterface $tokenStorage, AffectCompteRepository $affect)
    {
        $this->tokenStorage = $tokenStorage;  
        $this->affect=$affect;
    }
    public function __invoke(AffectCompte $data)
    {
        $datefin=$data->getDateDebut();//nouveau à affecté
          $d=$data->getUsers();
          $id=$this->affect->affectuser($d);

         $trouvefin= $id->getDateFin();//la date dejas affecé
         $trouveId= $id->getUsers()->getId();
         $Role=$data->getUsers()->getRole()->getLibelle();

         //Un utulisateur ne peut etre affecté qu'une seule fois dans une periode
       if($trouveId!=null && $datefin>=$trouvefin ){
        throw new HttpException(403,'ce utilisateur est déjas affecté à un utilisateur pour cette periode !!');

       }
          //impossible d'affecter  un Admin ou Super Admin à un Compte
          elseif($Role==self::ROLE_U_P || $Role==self::ROLE_A || $Role==self::ROLE_C || $Role==self::ROLE_P || $Role==self::ROLE_P_A){
            throw new HttpException(403,' ce utilisateur  ne peut pas etre affecté à un  comptes !!');
 
          }

        return $data;

        
    }
}
?>