<?php
namespace SimpleShop\Repository;

use SimpleShop\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findWithFilters(int $page, int $limit, ?string $category = null, ?string $search = null): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        if ($category) {
            $queryBuilder->join('p.category', 'c')
                ->andWhere('c.slug = :category')
                ->setParameter('category', $category);
        }

        if ($search) {
            $queryBuilder->andWhere('p.name LIKE :search OR p.description LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function countWithFilters(?string $category = null, ?string $search = null): int
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('COUNT(p.id)');

        if ($category) {
            $queryBuilder->join('p.category', 'c')
                ->andWhere('c.slug = :category')
                ->setParameter('category', $category);
        }

        if ($search) {
            $queryBuilder->andWhere('p.name LIKE :search OR p.description LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
