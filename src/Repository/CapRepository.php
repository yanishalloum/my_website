<?php

namespace App\Repository;

use App\Entity\Cap;
use App\Entity\User;
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

    public function findCapsForUser(User $user)
    {
        return $this->createQueryBuilder('cap')
            ->select('c')
            ->from('App\Entity\Cap', 'c')
            ->join('c.inventory', 'i')
            ->join('i.member', 'm')
            ->andWhere('m.user = :user')
            ->setParameter(':user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findByUser($user): array
    {
        return $this->createQueryBuilder('c')
           ->andWhere('c.inventory.user = :user')
           ->setParameter('user', $user)
           ->orderBy('c.id', 'ASC')
           //->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
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
