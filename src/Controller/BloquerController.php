<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class BloquerController{

    public function __construct(UserRepository $repo )
    {
       
        $this->repo=$repo;
    }

    public function __invoke(User $data)
    {
        
      $id=$_SERVER['REQUEST_URI'];
      $idUser= explode("/", $id);
      $img= $idUser[3];
       $user=$this->repo->find($img);

       if($user->getIsActive()===true){
         $user->setIsActive(false);
       }else{
         $user->setIsActive(true);
       }
      


      return $user;

    }
}
?>