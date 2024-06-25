<?php
/**
 * AdvertListInputFiltersDto resolver.
 */

namespace App\Resolver;

use App\Dto\AdvertListInputFiltersDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * AdvertListInputFiltersDtoResolver class.
 */
class AdvertListInputFiltersDtoResolver implements ValueResolverInterface
{
    /**
     * Returns the possible value(s).
     *
     * @param Request          $request  HTTP Request
     * @param ArgumentMetadata $argument Argument metadata
     *
     * @return iterable Iterable
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (!$argumentType || !is_a($argumentType, AdvertListInputFiltersDto::class, true)) {
            return [];
        }

        $categoryId = $request->query->get('category.id');

        return [new AdvertListInputFiltersDto($categoryId)];
    }
}
