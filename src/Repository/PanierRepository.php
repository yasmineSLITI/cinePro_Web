<?php

namespace App\Repository;

use App\Entity\Panier;
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }

    // /**
    //  * @return Classeroom[] Returns an array of Classeroom objects
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
    public function viderPnier(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("Delete  FROM APP\Entity\Panier p WHERE p.idpanier = 1")
          ;
        return $query->getResult();
    }
    public function getQt(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("Select pa.quantite  FROM APP\Entity\Panier pa ")
          ;
        return $query->getSingleScalarResult();
    }
   
   
}
