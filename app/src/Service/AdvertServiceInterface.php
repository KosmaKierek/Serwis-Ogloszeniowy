<?php
/**
 * Advert service interface.
 */

namespace App\Service;

use App\Dto\AdvertListInputFiltersDto;
use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\AdvertRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Interface AdvertServiceInterface.
 */
interface AdvertServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int                     $page    Page number
     * @param AdvertListInputFiltersDto $filters Filters
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, AdvertListInputFiltersDto $filters): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Advert $advert Advert entity
     */
    public function save(Advert $advert): void;

    /**
     * Delete entity.
     *
     * @param Advert $advert Advert entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Advert $advert): void;

}