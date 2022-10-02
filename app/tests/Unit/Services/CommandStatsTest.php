<?php

namespace Tests\Unit\Services;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Entities\CommandLog;
use Arslav\KnaaruBot\Services\CommandStatsService;
use Codeception\Test\Unit;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\Support\Fixture\FileFixture;
use Tests\Support\UnitTester;

class CommandStatsTest extends Unit
{
    protected CommandStatsService $service;

    protected UnitTester $tester;

    /**
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        $this->service = new CommandStatsService();
        $loader = new Loader();
        $loader->addFixture(new FileFixture(CommandLog::class, 'command_log.php'));
        $executor = new ORMExecutor(App::getEntityManager(), new ORMPurger());
        $executor->execute($loader->getFixtures());
        parent::setUp();
    }

    /**
     * @param string $command
     * @param int $from_id
     * @param int|null $chat_id
     * @return void
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @dataProvider commandProvider
     */
    public function testSaveUsage(string $command, int $from_id, ?int $chat_id): void
    {
        $this->service->saveUsage($command, $from_id, $chat_id);

        $params = [
            'command' => $command,
            'from_id' => $from_id,
        ];

        if ($chat_id) {
            $params['chat_id'] = $chat_id;
        } else {
            $params[] = Criteria::expr()->isNull('chat_id');
        }

        $this->tester->seeInRepository(CommandLog::class, $params);
    }

    /**
     * @param string $command
     * @param int $from_id
     * @param int|null $chat_id
     * @param int $expected
     * @return void
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @dataProvider commandUsagesProvider
     */
    public function testUsagesByInterval(string $command, int $from_id, ?int $chat_id, int $expected): void
    {
        $actual = $this->service->usagesByInterval(300, $command, $from_id, $chat_id);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     */
    public function testGetAllChatId(): void
    {
        $chat_ids = $this->service->getAllChatIds();
        $this->assertIsArray($chat_ids);
        $this->assertSame([2, 1], $chat_ids);
    }

    /**
     * @return array
     */
    public function commandProvider(): array
    {
        return [
            ['test', 1, null],
            ['test', 1, 1]
        ];
    }

    /**
     * @return array
     */
    public function commandUsagesProvider(): array
    {
        return [
            ['test1', 1, 1, 5],
            ['test1', 1, 2, 1],
            ['test1', 1, null, 2],
            ['test2', 1, 1, 0],
            ['test2', 1, null, 0],
        ];
    }
}
