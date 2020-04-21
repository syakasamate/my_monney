<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

class getOneUserController{

    public function __construct( UserRepository $repo)
    {
        $this->repo=$repo;
        
    }

    public function __invoke()
    {
        $id=$_SERVER['REQUEST_URI'];
       $idUser= explode("/", $id);
       $img= $idUser[3];
        $user=$this->repo->find($img);
   
            $user->setImage(base64_encode(stream_get_contents($user->getImage())));
            
        
                
    return $user;

    }

}


    
  
    

