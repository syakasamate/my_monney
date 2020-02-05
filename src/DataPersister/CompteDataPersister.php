<?php
namespace App\DataPersister;
use DateTime;
use Exception;
use App\Entity\Compte;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteDataPersister implements DataPersisterInterface
{

private $entityManager;
protected $tokenStorage;
private $repo;

public function __construct(EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage, CompteRepository $repo)
{
$this->entityManager = $entityManager;
$this->tokenStorage = $tokenStorage;
$this->repo=$repo;

}

public function supports($data):bool
{
return $data instanceof Compte;
}

/**
*@param Compte $data
*/
public function persist($data)
{
    

 $num=$this->repo->CompteNum();
 $numero = 'NCT' . sprintf("%06d", $num[1]+ 1) ;
$data->setNumero($numero);

$data->setDateCreation(new \DateTime());
$this->entityManager->persist($data);
$this->entityManager->flush();
    
}

public function remove($data)
{
$this->entityManager->remove($data);
$this->entityManager->flush();
}
}
?>
