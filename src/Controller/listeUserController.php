<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class listeUserController{

    public function __construct(UserRepository $repo,  TokenStorageInterface $tokenStorage )
    {
       
        $this->repo=$repo;
        $this->tokenStorage = $tokenStorage;

    }
    
    public function __invoke()
    {
     $user=$this->repo->listSupAdmin(1);
        
    return $user;
}
}

?>