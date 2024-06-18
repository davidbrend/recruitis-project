<?php

namespace App\Controller;

use App\Facades\RecruitisFacade;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Cache\InvalidArgumentException;
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
        $recruitisApiDto = $this->recruitisFacade->getCachedRecruitisDtomFromAPI($limit, $page);

        $totalEntries = $recruitisApiDto?->getMeta()->getEntriesTotal() ?? 0;
        $pagination = $this->paginator->paginate(range(1, $totalEntries), $page, $limit);

        $pagination->setItems($recruitisApiDto?->getJobs() ?? []);
        $pagination->setTotalItemCount($recruitisApiDto?->getMeta()->getEntriesTotal() ?? 0);

        return $this->render('default/homepage.html.twig', ['pagination' => $pagination, 'meta' => $recruitisApiDto?->getMeta()]);
    }
}