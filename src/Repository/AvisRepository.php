<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Avis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avis[]    findAll()
 * @method Avis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }
    

    // /**
    //  * @return Film[] Returns an array of Film objects
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
   
    */
    public function findAllmoy()
    {
      
       
            return $this->createQueryBuilder('s')
                
                ->innerJoin('App\Entity\Avis', 'avis', 'WITH', 'avis.idf = s.idf')
               
                ->select('AVG(avis.nbetoile)as moy')
               
                 ->groupBy('s.idf')
                
                ->getQuery()
                ->getResult()
            ;
        
        
    }
    public function uppdate($moy)
    {
      
    $update = $this->createQueryBuilder('r')
            ->update(Avis::class, 'r')
           ->set('r.moyenneavis', $moy)
            
           ->getQuery();
       
        $update->execute();
    }
   

}