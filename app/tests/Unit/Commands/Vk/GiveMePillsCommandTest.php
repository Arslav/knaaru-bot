<?php

namespace Tests\Unit\Commands\Vk;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Commands\Vk\GiveMePillsCommand;
use Arslav\KnaaruBot\Services\CommandStatsService;
use Arslav\KnaaruBot\Services\FileService;
use Codeception\Stub;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use DigitalStar\vk_api\vk_api;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class GiveMePillsCommandTest extends Unit
{
    protected GiveMePillsCommand $command;

    public function setUp(): void
    {
        $this->command = App::getContainer()->get(GiveMePillsCommand::class);
        $this->command->statsService = $this->constructEmpty(CommandStatsService::class);
        parent::setUp();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function testRun()
    {
        $this->command->fileService = $this->constructEmpty(
            FileService::class,
            [],
            [
                'getFiles' => fn() => [],
            ]
        );
        Stub::update(App::getVk(), [
            'reply' => Expected::once(),
            'sendImage' => Expected::never(),
        ]);

        $this->command->run();
    }

    public function testRunWithImage()
    {
        $this->command->fileService = $this->constructEmpty(
            FileService::class,
            [],
            [
                'getFiles' => fn() => ['file1', 'file2'],
            ]
        );
        Stub::update(App::getVk(), [
            'reply' => Expected::never(),
            'sendImage' => Expected::once(),
        ]);

        $this->command->run();
    }
}
