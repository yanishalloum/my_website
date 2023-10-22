<?php

namespace App\Repository;

use App\Entity\Cap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cap>
 *
 * @method Cap|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cap|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cap[]    findAll()
 * @method Cap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cap::class);
    }

//    /**
//     * @return Cap[] Returns an array of Cap objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cap
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
