<?php

namespace App\Facades;

use Davebrend\RecruitisApiProject\Clients\Query;
use Davebrend\RecruitisApiProject\Dtos\RecruitisApiDto;
use Davebrend\RecruitisApiProject\Facades\JobFacade;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RecruitisFacade
{
    private const CACHE_RECRUITIS_KEY = 'recruitis_dto';
    private const CACHE_RECRUITIS_EXPIRE_SECONDS = 3600;

    public function __construct(
        protected JobFacade $jobFacade,
        protected LoggerInterface $logger,
        protected CacheInterface $cache
    ){
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCachedRecruitisDtomFromAPI(): ?RecruitisApiDto
    {
        return $this->cache->get(self::CACHE_RECRUITIS_KEY, function (ItemInterface $item) {
            $item->expiresAfter(self::CACHE_RECRUITIS_EXPIRE_SECONDS);
            try {
                $query = new Query(); // Query params are defined in recruitis API documentation
                return $this->jobFacade->getRecruitisApiDtoByQuery($query);
            } catch (\Throwable $exception) {
                $this->logger->error($exception->getMessage());
                return null;
            }
        });
    }
}