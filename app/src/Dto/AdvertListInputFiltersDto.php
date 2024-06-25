<?php
/**
 * Advert list input filters DTO.
 */

namespace App\Dto;

/**
 * Class AdvertListInputFiltersDto.
 */
class AdvertListInputFiltersDto
{
    /**
     * Constructor.
     *
     * @param int|null $categoryId Category identifier
     */
    public function __construct(public readonly ?int $categoryId = null)
    {
    }
}