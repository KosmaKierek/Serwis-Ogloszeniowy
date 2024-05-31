<?php
/**
 * Advert controller.
 */

namespace App\Controller;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class AdvertController.
 */
#[Route('/advert')]
class AdvertController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request          HTTP Request
     * @param AdvertRepository   $advertRepository Advert repository
     * @param PaginatorInterface $paginator        Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'advert_index', methods: 'GET')]
    public function index(Request $request, AdvertRepository $advertRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $advertRepository->queryAll(),
            $request->query->getInt('page', 1),
            AdvertRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('advert/index.html.twig', ['pagination' => $pagination]);
    }
    /**
     * Show action.
     *
     * @param Advert $advert Advert entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'advert_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Advert $advert): Response
    {
        return $this->render(
            'advert/show.html.twig',
            ['advert' => $advert]
        );
    }
}
