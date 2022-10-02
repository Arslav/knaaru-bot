<?php

namespace Tests\Unit\Commands\Vk\Base;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Commands\Vk\Base\LimitedVkCommand;
use Arslav\KnaaruBot\Entities\CommandLog;
use Arslav\KnaaruBot\Services\CommandStatsService;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\Support\UnitTester;

class LimitedVkCommandTest extends Unit
{
    protected UnitTester $tester;

    protected LimitedVkCommand $command;

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    protected function setUp(): void
    {
        $container = App::getContainer();
        $this->command = $this->construct(
            LimitedVkCommand::class,
            [['test']],
            ['run' => Expected::never()]
        );
        $this->command->statsService = $container->get(CommandStatsService::class);
        parent::setUp();
    }

    /**
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testBeforeAction(): void
    {
        $this->tester->sendVkMessage('test');
        $this->command->init($this->tester->getVkMessageData());
        $this->assertSame(true, $this->command->beforeAction());
    }

    /**
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testBeforeActionLimit(): void
    {
        $this->tester->sendVkMessage('test');
        $this->command->init($this->tester->getVkMessageData());

        for($i = 0; $i < $this->command->limit; $i++) {
            $this->command->beforeAction();
        }

        $this->assertSame(false, $this->command->beforeAction());
        $this->tester->seeInRepository(CommandLog::class, [
            'command' => $this->command::class,
            'from_id' => $this->command->from_id,
        ]);
    }
}
