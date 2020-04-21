<?php

namespace App\Repository;

use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Compte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compte[]    findAll()
 * @method Compte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteRepository extends ServiceEntityRepository
{
    private $entityManager;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, Compte::class);
    }

    // /**
    //  * @return Compte[] Returns an array of Compte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Compte
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function CompteNum()
    {
        return $this->createQueryBuilder('m')
          ->select("Max(m.id)")
          ->orderBy('m.id', 'DESC ')
           // ->setMaxResults(10)
            ->getQuery()
            ->getSingleResult()  
        ;
    }
   

   /* public function CompteNum() {
        $lastId = $this->entityManager->getConnection()->lastInsertId();
        $compte = 'NCT' . sprintf("%06d", + 1) ;// C000002 if the last record ID is 1
        return $compte;
        
    }*/
}
