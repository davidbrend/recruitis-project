<?php

namespace App\Facades;

use Davebrend\RecruitisApiProject\Clients\Query;
use Davebrend\RecruitisApiProject\Dtos\Job;
use Davebrend\RecruitisApiProject\Facades\JobFacade;
use Psr\Log\LoggerInterface;

class RecruitisFacade
{
    public function __construct(protected JobFacade $jobFacade, protected LoggerInterface $logger)
    {
    }

    /**
     * @return array<Job>
     */
    public function getJobsFromRecruitisAPI(): array
    {
        try {
            $query = new Query(); // Query params are defined in recruitis API documentation
            $query->setLimit(1);
            return $this->jobFacade->getJobsByQuery($query);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
            return [];
        }
    }
}