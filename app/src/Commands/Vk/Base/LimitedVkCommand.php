<?php

namespace Arslav\KnaaruBot\Commands\Vk\Base;

use Arslav\Bot\Command;
use Arslav\KnaaruBot\Services\CommandStatsService;
use DI\Annotation\Inject;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;

abstract class LimitedVkCommand extends Command
{
    public int $limit = 10;

    public int $interval = 300;

    /**
     * @Inject
     * @var CommandStatsService
     */
    public CommandStatsService $statsService;

    /**
     * @return bool
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function beforeAction(): bool
    {
        $this->statsService->saveUsage(static::class, $this->message->getUserId(), $this->message->getChatId());
        return $this->checkLimit();
    }

    /**
     * @return bool
     *
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    protected function checkLimit(): bool
    {
        $usages = $this->statsService->usagesByInterval(
            $this->interval,
            static::class,
            $this->message->getUserId(),
            $this->message->getChatId()
        );
        return $usages < $this->limit;
    }
}
