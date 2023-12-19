<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Odometer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Odometer>
 *
 * @method Odometer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Odometer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Odometer[]    findAll()
 * @method Odometer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OdometerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Odometer::class);
    }

    public function add(Odometer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Odometer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findTheNewestByCar(?Car $car)
    {
        if ($car === null) {
            return null;
        }
        return $this->createQueryBuilder('o')
            ->andWhere('o.car = :car')
            ->setParameter('car', $car)
            ->setMaxResults(1)
            ->orderBy('o.date', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Odometer[] Returns an array of Odometer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Odometer
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
