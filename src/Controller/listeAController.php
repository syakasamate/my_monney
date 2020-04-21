<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Transaction;
use App\Repository\RolesRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class listeAController{

    public function __construct(RolesRepository $repo,  TokenStorageInterface $tokenStorage )
    {
       
        $this->repo=$repo;
        $this->tokenStorage = $tokenStorage;

    }
    
    public function __invoke()
    {

         $data6=$this->repo->findAll();
        $data=$this->repo->findByLibelle("ROLE_ADMIN");
        $data2=$this->repo->findByLibelle2("ROLE_CAISSIER");
        $data3=$this->repo->findByLibelle3("ROLE_PARTENAIRE");
        $data4=$this->repo->findByLibelle4("ROLE_ADMIN_PARTENAIRE");
        $data5=$this->repo->findByLibelle5("ROLE_USER_PARTENAIRE");
    
        if($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_SUPER_ADMIN"){
     
      $user=[$data,$data2,$data3];
        }
    elseif($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_ADMIN"){
        $user=[$data2,$data3];
    } 
    elseif($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_PARTENAIRE"){
        $user=[$data4,$data5];
    } elseif($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_ADMIN_PARTENAIRE"){
        $user=[$data5];
    }
    return $user;
}
}

?>