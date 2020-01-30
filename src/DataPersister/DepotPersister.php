<?php
namespace App\DataPersister;
use DateTime;
use Exception;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Repository\DepotRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DepotPersister implements DataPersisterInterface
{

private $entityManager;
protected $tokenStorage;

public function __construct(EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage, DepotRepository $depot)
{
$this->entityManager = $entityManager;
$this->depot=$depot;
}

public function supports($data):bool
{
return $data instanceof Depot;
}

/**
*@param Depot $data
*/
public function persist($data)
{
  
$montant=$data->getMontant();
$montantCmopte=$data->getCompte()->getSolde();
$somtotal=$montant+$montantCmopte;
$data->getCompte()->SetSolde($somtotal);
$data->setDateDepot(new \DateTime());
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
