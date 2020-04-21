<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

class getUserController{

    public function __construct( UserRepository $repo)
    {
        $this->repo=$repo;
        
    }

    public function __invoke()  
    {

      $data =$this->repo->findAll();

foreach ($data as $value) {
    if($value->getImage()){
    $value->setImage(base64_encode(stream_get_contents($value->getImage())));
    }

           }
           return $data;

    }


}
    
  
    

