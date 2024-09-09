<?php
/**
 * Advert controller.
 */

namespace App\Controller;

use App\Dto\AdvertListInputFiltersDto;
use App\Entity\Advert;
use App\Resolver\AdvertListInputFiltersDtoResolver;
use App\Entity\User;
use App\Form\Type\AdvertType;
use App\Service\AdvertService;
use App\Service\CategoryServiceInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class AdvertController.
 */
#[Route('/advert')]
class AdvertController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param AdvertService            $advertService   Advert service
     * @param TranslatorInterface      $translator      Translator interface
     * @param CategoryServiceInterface $categoryService Category service interface
     */
    public function __construct(private AdvertService $advertService, private readonly TranslatorInterface $translator, private readonly CategoryServiceInterface $categoryService)
    {
        $this->advertService = $advertService;
    }

    /**
     * Index action.
     *
     * @param AdvertListInputFiltersDto $filters Input filters
     * @param int                       $page    Page number
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'advert_index',
        methods: 'GET'
    )]
    public function index(#[MapQueryString(resolver: AdvertListInputFiltersDtoResolver::class)] AdvertListInputFiltersDto $filters, #[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->advertService->getPaginatedList(
            $page,
            $filters
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
    #[Route('/{id}', name: 'advert_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    public function show(Advert $advert): Response
    {
        return $this->render('advert/show.html.twig', ['advert' => $advert]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     */
    #[Route(
        '/create',
        name: 'advert_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $advert = new Advert();
        $advert->setAuthor($user);
        $form = $this->createForm(
            AdvertType::class,
            $advert,
            ['action' => $this->generateUrl('advert_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->advertService->save($advert);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('advert_index');
        }

        return $this->render(
            'advert/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Advert  $advert  Advert entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     */
    #[Route('/{id}/edit', name: 'advert_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('EDIT', subject: 'advert')]
    public function edit(Request $request, Advert $advert): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash(
                'danger',
                $this->translator->trans('message.not_allowed')
            );

            return $this->redirectToRoute('app_login');
        }

        // if (!$this->isGranted('ROLE_ADMIN')) {
        // $this->addFlash(
        // 'danger',
        // $this->translator->trans('message.not_allowed')
        // );
        // $this->redirectToRoute('advert_index');
        // }
        $form = $this->createForm(
            AdvertType::class,
            $advert,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('advert_edit', ['id' => $advert->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->advertService->save($advert);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('advert_index');
        }

        return $this->render(
            'advert/edit.html.twig',
            [
                'form' => $form->createView(),
                'advert' => $advert,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Advert  $advert  Advert entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'advert_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    #[IsGranted('DELETE', subject: 'advert')]
    public function delete(Request $request, Advert $advert): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash(
                'danger',
                $this->translator->trans('message.not_allowed')
            );

            return $this->redirectToRoute('app_login');
        }
        // if (!$this->isGranted('ROLE_ADMIN')) {
        // ->addFlash(
        // 'danger',
        // $this->translator->trans('message.not_allowed')
        // );
        // return $this->redirectToRoute('advert_index');
        // }
        $form = $this->createForm(
            FormType::class,
            $advert,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('advert_delete', ['id' => $advert->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->advertService->delete($advert);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('advert_index');
        }

        return $this->render(
            'advert/delete.html.twig',
            [
                'form' => $form->createView(),
                'advert' => $advert,
            ]
        );
    }
}
