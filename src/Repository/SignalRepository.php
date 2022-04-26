<?php

namespace App\Repository;

use App\Entity\Signale;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Signale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Signale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Signale[]    findAll()
 * @method Signale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Signale::class);
    }

    // /**
    //  * @return Publication[] Returns an array of Classeroom objects
    //  */
    
    public function sumSig()
    {
        return $this->createQueryBuilder('s')
            ->select('SUM(s.nbresignal) as somme')
            ->groupBy('s.idpub')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Classeroom
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneBySomeField()
    {
        $qb  = $this->_em->createQueryBuilder();
        $qb2 = $qb;
        $qb2->select('s.idpub')
                ->from('App\Entity\Signale', 'ms');
        
            $qb  = $this->_em->createQueryBuilder();
            $qb->delete('App\Entity\Publication', 's')
                
                ->where($qb->expr()->In('s.idpub', $qb2->getDQL())
            );
            $query  = $qb->getQuery();
            return $query->getResult();
        
    }
    
}
