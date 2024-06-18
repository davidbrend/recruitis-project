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

    #[Route('/', name: 'homepage')]
    public function homepage(
        #[MapQueryParameter] int $limit = 10,
        #[MapQueryParameter] int $page = 1
    ): Response
    {
        $recruitisApiDto = $this->recruitisFacade->getCachedRecruitisDtomFromAPI($limit, $page);

        $pagination = $this->paginator->paginate([], $page, $limit);
        $pagination->setTotalItemCount($recruitisApiDto?->getMeta()->getEntriesTotal() ?? 0);
        $pagination->setItems($recruitisApiDto?->getJobs() ?? []); // is required to set items like this because of compatibility with API results

        return $this->render('default/homepage.html.twig', [
            'pagination' => $pagination,
            'meta' => $recruitisApiDto?->getMeta(),
        ]);
    }
}