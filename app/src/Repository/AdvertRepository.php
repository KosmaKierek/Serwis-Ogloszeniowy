<?php
/**
 * Advert repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Advert;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AdvertRepository.
 *
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Advert>
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 */
class AdvertRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial advert.{id, createdAt, updatedAt, title}',
                'partial category.{id, title}',
                //'partial tags.{id, title}'
            )
            ->join('advert.category', 'category')
            //->join('advert.tags', 'tags')
            ->orderBy('advert.createdAt', 'DESC');
    }

    /**
     * Save entity.
     *
     * @param Advert $advert Advert entity
     */
    public function save(Advert $advert): void
    {
        assert($this->_em instanceof EntityManager);
        $this->_em->persist($advert);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Advert $advert Advert entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Advert $advert): void
    {
        assert($this->_em instanceof EntityManager);
        $this->_em->remove($advert);
        $this->_em->flush();

    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        $queryBuilder = null;
        return $queryBuilder ?? $this->createQueryBuilder('advert');
    }

    /**
     * Count adverts by category.
     *
     * @param Category $category Category
     *
     * @return int Number of adverts in category
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('advert.id'))
            ->where('advert.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
