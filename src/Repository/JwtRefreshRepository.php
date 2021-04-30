<?php

namespace App\Repository;

use App\Entity\JwtRefresh;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JwtRefresh|null find($id, $lockMode = null, $lockVersion = null)
 * @method JwtRefresh|null findOneBy(array $criteria, array $orderBy = null)
 * @method JwtRefresh[]    findAll()
 * @method JwtRefresh[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JwtRefreshRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JwtRefresh::class);
    }

    // /**
    //  * @return JwtRefresh[] Returns an array of JwtRefresh objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JwtRefresh
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
