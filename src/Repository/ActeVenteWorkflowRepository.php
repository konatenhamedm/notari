<?php

namespace App\Repository;

use App\Entity\ActeVenteWorkflow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActeVenteWorkflow>
 *
 * @method ActeVenteWorkflow|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActeVenteWorkflow|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActeVenteWorkflow[]    findAll()
 * @method ActeVenteWorkflow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActeVenteWorkflowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActeVenteWorkflow::class);
    }

    public function add(ActeVenteWorkflow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ActeVenteWorkflow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ActeVenteWorkflow[] Returns an array of ActeVenteWorkflow objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ActeVenteWorkflow
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
