<?php

namespace App\Controller;

use App\Facades\RecruitisFacade;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(protected RecruitisFacade $recruitisFacade, protected PaginatorInterface $paginator)
    {
    }

    #[Route('/', 'homepage')]
    public function homepage(
        #[MapQueryParameter] int $limit = 10,
        #[MapQueryParameter] int $page = 1
    ): Response
    {
        $dto = $this->recruitisFacade->getCachedRecruitisDtomFromAPI($limit, $page);
        $pagination = $this->paginator->paginate($dto?->getJobs() ?? [], $page, $limit);
        return $this->render('default/homepage.html.twig', ['pagination' => $pagination]);
    }
}