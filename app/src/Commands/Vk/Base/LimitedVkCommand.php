<?php

namespace Arslav\KnaaruBot\Commands\Vk\Base;

use Arslav\Bot\Vk\Command;
use Arslav\Bot\Commands\Vk\Base\VkCommand;
use Arslav\KnaaruBot\Services\CommandStatsService;
use DI\Annotation\Inject;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
     * @throws ContainerExceptionInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function beforeAction(): bool
    {
        $this->statsService->saveUsage(static::class, $this->from_id, $this->chat_id);
        return $this->checkLimit();
    }

    /**
     * @return bool
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    protected function checkLimit(): bool
    {
        $usages = $this->statsService->usagesByInterval(
            $this->interval,
            static::class,
            $this->from_id,
            $this->chat_id
        );
        return $usages < $this->limit;
    }
}
