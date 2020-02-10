<?php
namespace App\DataPersister;
use DateTime;
use Exception;
use App\Entity\Compte;
use App\Repository\CompteRepository;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Repository\PartenaireRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteDataPersister implements DataPersisterInterface
{

private $entityManager;
protected $tokenStorage;
private $repo;

public function __construct(PartenaireRepository $part, ContratRepository $contrat,EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage, CompteRepository $repo)
{
$this->entityManager = $entityManager;
$this->tokenStorage = $tokenStorage;
$this->repo=$repo;
$this->contrat=$contrat;
$this->part=$part;

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

$contrat1=$this->contrat->find(1);
 $data->getPartenaires()->setContrat($contrat1);

//on genere le contrat pour les nouveau partenaire
 $id=$data->getPartenaires()->getId();
 $parte=$this->part->PartExist($id);

 
 
$this->entityManager->persist($data);
$this->entityManager->flush();
if( $parte==null){
    $contrat=array(
        "numero de compte"=>$data->getNumero(),
        "createur de de comte"=>$data->getUsercreateur()->getUsername(),
        "date contrat"=>$data->getDateCreation(),
       "les les Articles"=>$contrat1->getTermes()
    );
return new JsonResponse($contrat); 
 }

}
public function remove($data)
{
$this->entityManager->remove($data);
$this->entityManager->flush();
}
}
?>
