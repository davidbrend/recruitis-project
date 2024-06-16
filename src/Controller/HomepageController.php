<?php

namespace App\Controller;

use Davebrend\RecruitisApiProject\Client\Query;
use Davebrend\RecruitisApiProject\Facades\JobFacade;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    #[Route('/', 'homepage')]
    public function homepage(JobFacade $jobFacade): Response
    {
        $query = new Query();
        $query->setLimit(1);
        $jobs = $jobFacade->getJobsByQuery($query);

        return $this->render('default/homepage.html.twig');
    }
}