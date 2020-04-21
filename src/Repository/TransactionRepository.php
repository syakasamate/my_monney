<?php

namespace App\Repository;

use Osms\Osms;
use App\Entity\Transaction;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    // /**
    //  * @return Transaction[] Returns an array of Transaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function numeroAction()
    {
        $numero = mt_rand(0, 1000000000000);

        return $numero;
        
    }

    /*public function   affichePart()
    {
        $rawSql = "SELECT  t.commision_wari,t.part_etat  FROM   transaction  AS t";
    
        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
    
        return $stmt->fetchAll();
    }*/

    public function  affichePart()
    {
        return $this->createQueryBuilder('t')
            ->select('t.commisionWari,t.partEtat,t.commissionEmeteur,t.commissionRecepteur')
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function sendMessage($numEnv, $numRecp,$nomEnv,$montantnet,$code){
        $config = array(
            'clientId' => '5y49xsv7zkGK8cZj6J4IM4c5j2FNOBhA',
            'clientSecret' => 'qzgeEnI26NduRdKP'
        );

        $osms = new Osms($config);

        // retrieve an access token
        $response = $osms->getTokenFromConsumerKey();

        if (!empty($response['access_token'])) {
            $senderAddress = 'tel:+221'.$numEnv;
            $receiverAddress = 'tel:+221'.$numRecp;
            $message = ' Bienvenu sur Kodo TRansfert'.'  '.$nomEnv. '  '.'Vient de vous envoyé  '.$montantnet.'fcf  '.'le code est'.
            $code;
            $senderName = 'Optimus Prime';

            $osms->sendSMS($senderAddress, $receiverAddress, $message, $senderName);
        } else {
            // error
        }

    }
    public function recevMessage($numEnv, $numRecp,$nomRecep,$montantnet){
        $config = array(
            'clientId' => '5y49xsv7zkGK8cZj6J4IM4c5j2FNOBhA',
            'clientSecret' => 'qzgeEnI26NduRdKP'
        );

        $osms = new Osms($config);

        // retrieve an access token
        $response = $osms->getTokenFromConsumerKey();

        if (!empty($response['access_token'])) {
            $senderAddress = 'tel:+221'.$numRecp;
            $receiverAddress = 'tel:+221'.$numEnv;
            $message = ' Bienvenu sur Kodo TRansfert le '.'  '.$montantnet.'fcf  '. 'Envoyé à '.'  ' .$nomRecep.'  '.'vient d\'etre retiré' ;

            $senderName = 'Optimus Prime';

            $osms->sendSMS($senderAddress, $receiverAddress, $message, $senderName);
        } else {
            // error
        }

    }
}
