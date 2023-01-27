<?php

namespace App\Repository;

use App\Entity\UserFidelityPoints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserFidelityPoints>
 *
 * @method UserFidelityPoints|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFidelityPoints|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFidelityPoints[]    findAll()
 * @method UserFidelityPoints[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFidelityPointsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFidelityPoints::class);
    }

    public function save(UserFidelityPoints $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserFidelityPoints $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserFidelityPoints[] Returns an array of UserFidelityPoints objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserFidelityPoints
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
