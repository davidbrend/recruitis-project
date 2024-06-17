<?php

namespace App\Controller;

use App\Facades\RecruitisFacade;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{

    public function __construct(protected RecruitisFacade $recruitisFacade)
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/', 'homepage')]
    public function homepage(): Response
    {
        $dto = $this->recruitisFacade->getCachedRecruitisDtomFromAPI();
        return $this->render('default/homepage.html.twig', [
            'jobs' => $dto?->getJobs()
        ]);
    }
}