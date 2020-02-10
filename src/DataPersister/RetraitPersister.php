<?php
namespace App\DataPersister;
use App\Entity\Transaction;
use App\Repository\DepotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RetraitPersister implements DataPersisterInterface
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
return $data instanceof Transaction;
}

/**
*@param Transaction $data
*/
public function persist($data)
{
  
    $retrait=array(
        "Reçu"=>"kodo_Transfert",
         "Numero Transaction"=>$data->getId(),
        "Code Transaction:"=>$data->getCode(),
        "Nom De Recepteur:"=>$data->getPrenomBenef(),
        "Montant:"=>$data->getMontant(),
        "Date Retrait"=>$data->getDateRetret(),
        );
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return new JsonResponse($retrait); 
    
}
public function remove($data)
{
$this->entityManager->remove($data);
$this->entityManager->flush();
}
}
?>
