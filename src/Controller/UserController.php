<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;



private $validator;
    public function __construct( ValidatorInterface $validator, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder,TokenStorageInterface $tokenStorage)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        
    }

    public function __invoke(User $data): User
    {
    

          if ($data->getPassword()) {
            $data->setPassword(
                $this->userPasswordEncoder->encodePassword($data, $data->getPassword())
            );
            $data->eraseCredentials();
         }
          
          $data->setIsActive(1);
           if($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_PARTENAIRE"){
            $partenaire =$this->tokenStorage->getToken()->getUser()->getPartenaire();
            $data->setPartenaire($partenaire);
         
           }
           
        return $data;
    }


}
?>