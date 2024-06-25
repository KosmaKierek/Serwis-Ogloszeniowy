<?php
/**
 * Advert list filters DTO.
 */

namespace App\Dto;

use App\Entity\Category;

/**
 * Class AdvertListFiltersDto.
 */
class AdvertListFiltersDto
{
    /**
     * Constructor.
     *
     * @param Category|null $category   Category entity
     */
    public function __construct(public readonly ?Category $category)
    {
    }
}