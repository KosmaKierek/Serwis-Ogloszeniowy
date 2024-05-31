<?php
/**
 * Advert controller.
 */

namespace App\Controller;

use App\Entity\Advert;
use App\Service\AdvertService;
use App\Service\AdvertServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class AdvertController.
 */
#[Route('/advert')]
class AdvertController extends AbstractController
{
    /**
     * Constructor.
     */
    public function __construct(private readonly AdvertServiceInterface $advertService)
    {
    }

    /**
     * Index action.
     *
     * @param int $page Page number
     *
     * @return Response HTTP response
     */
    #[Route(name: 'advert_index', methods: 'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->advertService->getPaginatedList($page);

        return $this->render('advert/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Advert $advert Advert
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'advert_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Advert $advert): Response
    {
        return $this->render('advert/show.html.twig', ['advert' => $advert]);
    }
}
