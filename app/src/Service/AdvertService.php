<?php
/**
 * Advert service.
 */

namespace App\Service;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class AdvertService.
 */
class AdvertService implements AdvertServiceInterface
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    private const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param AdvertRepository     $advertRepository Advert repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(private readonly AdvertRepository $advertRepository, private readonly PaginatorInterface $paginator)
    {
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->advertRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Advert $advert Advert entity
     */
    public function save(Advert $advert): void
    {
        $this->advertRepository->save($advert);
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
        $this->advertRepository->delete($advert);
    }


}
