<?php

namespace Arslav\KnaaruBot\Services;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Entities\CommandLog;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query\Parameter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CommandStatsService
{
    public EntityManager $em;
    public EntityRepository $repository;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        //TODO: Переписать на DI
        $this->em = App::getEntityManager();
        $this->repository = $this->em->getRepository(CommandLog::class);
    }

    /**
     * @param string $commandClass
     * @param int $from_id
     * @param int|null $chat_id
     * @return void
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveUsage(string $commandClass, int $from_id, int $chat_id = null): void
    {
        $command_log = new CommandLog();
        $command_log->setCommand($commandClass);
        $command_log->setFromId($from_id);
        $command_log->setChatId($chat_id);
        $this->em->persist($command_log);
        $this->em->flush($command_log);
    }

    /**
     * @param int $interval
     * @param string $commandClass
     * @param int $from_id
     * @param int|null $chat_id
     *
     * @return int
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function usagesByInterval(int $interval, string $commandClass, int $from_id, int $chat_id = null): int
    {
        $params = new ArrayCollection([
            new Parameter('start', Carbon::now()->timestamp - $interval),
            new Parameter('end', Carbon::now()->timestamp),
            new Parameter('from_id', $from_id),
            new Parameter('command', $commandClass),
        ]);

        $query = $this->repository->createQueryBuilder('l')
            ->select('count(l.id)')
            ->where('l.created_at BETWEEN :start AND :end')
            ->andWhere('l.command = :command')
            ->andWhere('l.from_id = :from_id')
            ->setParameters($params);

        if ($chat_id) {
            $params->add(new Parameter('chat_id', $chat_id));
            $query->andWhere('l.chat_id = :chat_id');
        } else {
            $query->andWhere($query->expr()->isNull('l.chat_id'));
        }

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * @return array
     */
    public function getAllChatIds(): array
    {
        $query = $this->repository->createQueryBuilder('c');

        $query->select('c.chat_id')
            ->where($query->expr()->isNotNull('c.chat_id'))
            ->distinct();

        $result = $query->getQuery()->getArrayResult();

        return array_column($result, 'chat_id');
    }
}
