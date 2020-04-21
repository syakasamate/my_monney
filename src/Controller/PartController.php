<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class PartController{

    public function __construct(TransactionRepository $repo )
    {
       
        $this->repo=$repo;
    }

    public function __invoke()
    {

     
        $cible = $this->repo->affichePart();
     

        return $cible;
       
    }
}
?>