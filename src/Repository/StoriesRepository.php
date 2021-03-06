<?php

namespace App\Repository;

use App\Entity\Stories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stories>
 *
 * @method Stories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stories[]    findAll()
 * @method Stories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stories::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Stories $entity, bool $flush = true): void
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
    public function remove(Stories $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Stories[] Returns an array of Stories objects
     */
    public function findBest()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.liked', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Reviews[] Returns an array of Reviews objects
    //  */
    public function findOneRand()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery( "SELECT s FROM App\Entity\Stories s ORDER BY RAND()" )
            ->setMaxResults(1)
        ;

        // returns an array of Product objects
        return $query->execute();
    }

    // /**
    //  * @return Stories[] Returns an array of Stories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stories
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
