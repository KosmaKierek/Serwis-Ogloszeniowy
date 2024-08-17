<?php
/**
 * Advert service.
 */

namespace App\Service;

use App\Dto\AdvertListFiltersDto;
use App\Dto\AdvertListInputFiltersDto;
use App\Entity\Advert;
use App\Entity\Category;
use App\Repository\AdvertRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
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
     * @param CategoryServiceInterface $categoryService  Category service
     * @param PaginatorInterface       $paginator        Paginator
     * @param TagServiceInterface      $tagService       Tag service
     * @param AdvertRepository         $advertRepository Advert repository
     */
    public function __construct(private readonly CategoryServiceInterface $categoryService, private readonly PaginatorInterface $paginator, private readonly TagServiceInterface $tagService, private readonly AdvertRepository $advertRepository)
    {
    }

    /**
     * Get paginated list.
     *
     * @param int                       $page    Page number
     * @param AdvertListInputFiltersDto $filters Filters
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, AdvertListInputFiltersDto $filters): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->advertRepository->queryByAuthor($filters),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Advert $advert Advert entity
     *
     * @throws \Doctrine\ORM\Exception\ORMException
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

    /**
     * Prepare filters for the adverts list.
     *
     * @param AdvertListInputFiltersDto $filters Raw filters from request
     *
     * @return AdvertListFiltersDto Result filters
     */
    private function prepareFilters(AdvertListInputFiltersDto $filters): AdvertListFiltersDto
    {
        return new AdvertListFiltersDto(
            null !== $filters->categoryId ? $this->categoryService->findOneById($filters->categoryId) : null,
            null !== $filters->tagId ? $this->tagService->findOneById($filters->tagId) : null,
        );
    }
}
