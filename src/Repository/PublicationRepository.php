<?php

namespace App\Repository;

use App\Entity\Publication;
use App\Entity\Signale;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    // /**
    //  * @return Publication[] Returns an array of Publication objects
    //  */


    public function findByArchive()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.archive = :archive')
            ->setParameter('archive', 1)

            ->getQuery()
            ->getResult();
    }
    public function findByArch()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.archive = :archive')
            ->setParameter('archive', 0)

            ->getQuery()
            ->getResult();
    }

    public function filterbydate($Date)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('e')
            ->from('App\Entity\Publication',  'e')
            ->setParameter('date', $Date)
            ->orderBy('e.datecreationpub', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*public function findOneBynbresignal($value)
    {
        $qb  = $this->_em->createQueryBuilder();
        $qb2 = $qb;
        $qb2->select('s.idpub')
            ->from('App\Entity\Signale', 's');

        $qb  = $this->_em->createQueryBuilder();
        $qb->delete('App\Entity\Publication', 'p')

            ->where(
                $qb->expr()->In('p.idpub', $qb2->getDQL())
            );
        $query  = $qb->getQuery();
        return $query->getResult();
    }*/

    public function deletePublication($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'DELETE FROM publication
             WHERE publication.idPub  
             IN (SELECT idPub FROM signal WHERE SUM(nbreSignal)>5 GROUP BY (idPub) )'
        )->setParameter('', $value);

        // returns an array of Product objects
        return $query->getResult();
    }
}
