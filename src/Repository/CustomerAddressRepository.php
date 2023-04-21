<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CustomerAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerAddress>
 *
 * @method null|CustomerAddress find($id, $lockMode = null, $lockVersion = null)
 * @method null|CustomerAddress findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerAddress[] findAll()
 * @method CustomerAddress[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CustomerAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerAddress::class);
    }

    public function save(CustomerAddress $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerAddress $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//  /**
//   * @return CustomerAddress[] Returns an array of CustomerAddress objects
//   */
//  public function findByExampleField($value): array
//  {
//      return $this->createQueryBuilder('c')
//          ->andWhere('c.exampleField = :val')
//          ->setParameter('val', $value)
//          ->orderBy('c.id', 'ASC')
//          ->setMaxResults(10)
//          ->getQuery()
//          ->getResult()
//      ;
//  }

//  public function findOneBySomeField($value): ?CustomerAddress
//  {
//      return $this->createQueryBuilder('c')
//          ->andWhere('c.exampleField = :val')
//          ->setParameter('val', $value)
//          ->getQuery()
//          ->getOneOrNullResult()
//      ;
//  }
}
