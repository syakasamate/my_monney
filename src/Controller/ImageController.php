<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

class ImageController{

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
      $image=file_get_contents($_FILES['image']['tmp_name']);
      $user->setImage($image);


    return $user;

    }

}


    
  
    

