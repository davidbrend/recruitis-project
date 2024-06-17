<?php

namespace App\Facades;

use Davebrend\RecruitisApiProject\Clients\Query;
use Davebrend\RecruitisApiProject\Dtos\RecruitisApiDto;
use Davebrend\RecruitisApiProject\Enums\ActivityStateEnum;
use Davebrend\RecruitisApiProject\Facades\JobFacade;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RecruitisFacade
{
    private const CACHE_RECRUITIS_KEY = 'recruitis_dto';
    private const CACHE_RECRUITIS_EXPIRE_SECONDS = 60;

    public function __construct(
        protected JobFacade $jobFacade,
        protected LoggerInterface $logger,
        protected CacheInterface $cache
    ){
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCachedRecruitisDtomFromAPI(int $limit, int $page): ?RecruitisApiDto
    {
        return $this->cache->get($this->generateCacheKey($limit, $page), function (ItemInterface $item) use ($limit, $page) {
            $item->expiresAfter(self::CACHE_RECRUITIS_EXPIRE_SECONDS);
            try {
                $query = new Query(); // Query params are defined in recruitis API documentation
                $query->setLimit($limit)
                    ->setPage($page)
                    ->setActivityState(ActivityStateEnum::ACTIVE_POSITION);

                return $this->jobFacade->getRecruitisApiDtoByQuery($query);
            } catch (\Throwable $exception) {
                $this->logger->error($exception->getMessage());
                return null;
            }
        });
    }

    private function generateCacheKey(int $limit, int $page): string
    {
        return self::CACHE_RECRUITIS_KEY . '_limit_' . $limit . '_page_' . $page;
    }
}