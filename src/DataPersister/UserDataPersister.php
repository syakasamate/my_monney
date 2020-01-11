<?php
namespace App\DataPersister;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserDataPersister implements DataPersisterInterface
{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;


public function __construct(EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder,TokenStorageInterface $tokenStorage)
{
$this->entityManager = $entityManager;
$this->userPasswordEncoder = $userPasswordEncoder;
$this->tokenStorage = $tokenStorage;

}

public function supports($data): bool
{
return $data instanceof User;
}

/**
* @param User $data
*/
public function persist($data)
{
if($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_ADMIN"){
    if ($data->getRoles()[0]=="ROLE_SUPER_ADMIN" || $data->getRoles()[0]=="ROLE_ADMIN"){
        throw new Exception(" Desolé  Vous n'avez pas le droit de creer ou modifier  ni un SUPER_ADMIN ni un ADMIN");
    }
    
}else{

if ($data->getPassword()) {
$data->setPassword(
$this->userPasswordEncoder->encodePassword($data, $data->getPassword())

);
$data->eraseCredentials();
}

$this->entityManager->persist($data);
$this->entityManager->flush();
}
}
public function remove($data)
{
$this->entityManager->remove($data);
$this->entityManager->flush();
}
}
?>
