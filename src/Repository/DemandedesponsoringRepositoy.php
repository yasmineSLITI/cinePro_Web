<?php

namespace App\Repository;

use App\Entity\Demandedesponsoring;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Demandedesponsoring|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demandedesponsoring|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demandedesponsoring[]|null   findAll()
 * @method Demandedesponsoring[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandedesponsoringRepositoy extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demandedesponsoring::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Demandedesponsoring $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Demandedesponsoring $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * 
     */
    public function accepter($id){
        return $this->createQueryBuilder('r')
        ->update()
        ->set('r.etataccept','?2')
        ->setParameter(2,'Accepté')
        ->where('r.iddemande IN (?1)')
        ->setParameter(1,$id)
        ->getQuery()
        ->execute()
        ;
    }
    /**
     * 
     */
    public function refusing($id){
        return $this->createQueryBuilder('r')
        ->update()
        ->set('r.etataccept','?2')
        ->setParameter(2,'Refusé')
        ->where('r.iddemande IN (?1)')
        ->setParameter(1,$id)
        ->getQuery()
        ->execute()
        ;
    }



    /**
     * @throws ORMException
     * @throws OptimisticLockException 
     */
    public function findBySponsId(int $id){
       /*
        return $this->_em->getEntityManager()
        ->createQueryBuilder()
        ->select('r')
        ->from('CRMCoreBundle:Route', 'r')
        ->innerJoin('r.routegroup','rg')
        ->innerJoin('rg.profiles','p')
        ->innerJoin('p.users','u')
        ->where('u.id = :user_id')
        ->setParameter('user_id',$id)
        ->getQuery()
        ->getResult();
        /* $this->_em->createQuery('SELECT d FROM CRMCoreBundle:Demandedesponsoring u
        JOIN CRMCoreBundle:Sponsor p
        WHERE
          u.id=:user')
          ->setParameter('user', $id)
          ->getResult();*/
        $query=$this->_em
            ->createQuery("SELECT d FROM  App\Entity\Demandedesponsoring d , 
            APP\Entity\Sponsor s
            WHERE  d.idsp= s AND s.idsp = :idd")
            ->setParameter('idd',$id);
        ;
        return $query->execute();
    }
    // /**
    //  * @return Demandedesponsoring[] Returns an array of Demandedesponsoring objects
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
    public function findOneBySomeField($value): ?Demandedesponsoring
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
