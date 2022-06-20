<?php

namespace App\Repository;

use App\Entity\GestionTypeActe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GestionTypeActe>
 *
 * @method GestionTypeActe|null find($id, $lockMode = null, $lockVersion = null)
 * @method GestionTypeActe|null findOneBy(array $criteria, array $orderBy = null)
 * @method GestionTypeActe[]    findAll()
 * @method GestionTypeActe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GestionTypeActeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GestionTypeActe::class);
    }

    public function add(GestionTypeActe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GestionTypeActe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GestionTypeActe[] Returns an array of GestionTypeActe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GestionTypeActe
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
