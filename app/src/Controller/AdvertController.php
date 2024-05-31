<?php
/**
 * Advert controller.
 */

namespace App\Controller;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @param AdvertRepository $advertRepository Advert repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'advert_index',
        methods: 'GET'
    )]
    public function index(AdvertRepository $advertRepository): Response
    {
        $adverts = $advertRepository->findAll();

        return $this->render(
            'advert/index.html.twig',
            ['adverts' => $adverts]
        );
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
