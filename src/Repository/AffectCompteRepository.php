<?php

namespace App\Repository;

use App\Entity\AffectCompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AffectCompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffectCompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffectCompte[]    findAll()
 * @method AffectCompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectCompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AffectCompte::class);
    }

    // /**
    //  * @return AffectCompte[] Returns an array of AffectCompte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AffectCompte
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function user($user): ?AffectCompte
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.users= :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function    DateBetween($date)
    {
        return $this->createQueryBuilder('a')
             ->where('a.dedebut< :date')
            ->andWhere('a.datefin> :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function   affectuser($value): ?AffectCompte
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.users =:val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }



}
