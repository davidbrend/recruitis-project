<?php

namespace App\Controller;

use App\Facades\RecruitisFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{

    public function __construct(protected RecruitisFacade $recruitisFacade)
    {
    }

    #[Route('/', 'homepage')]
    public function homepage(): Response
    {
        $jobs = $this->recruitisFacade->getJobsFromRecruitisAPI();
        return $this->render('default/homepage.html.twig');
    }
}