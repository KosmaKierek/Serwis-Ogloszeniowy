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
     * @param int|null $tagId      Tag identifier
     */
    public function __construct(public readonly ?int $categoryId = null, public readonly ?int $tagId = null)
    {
    }
}
