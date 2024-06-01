<?php
/**
 * Advert service interface.
 */

namespace App\Service;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
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
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;
}
