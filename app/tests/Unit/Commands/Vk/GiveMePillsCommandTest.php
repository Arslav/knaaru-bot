<?php

namespace Tests\Unit\Commands\Vk;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Commands\Vk\GiveMePillsCommand;
use Arslav\KnaaruBot\Services\FileService;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use DI\DependencyException;
use DI\NotFoundException;
use DigitalStar\vk_api\vk_api;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class GiveMePillsCommandTest extends Unit
{

    /**
     * @return void
     *
     * @throws VkApiException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithImages(): void
    {
        $container = App::getContainer();
        $container->set(vk_api::class, $this->constructEmpty(
            vk_api::class,
            [null, null],
            ['sendImage' => Expected::once()]
        ));
        $command = $container->get(GiveMePillsCommand::class);

        $command->run();
    }

    /**
     * @return void
     *
     * @throws VkApiException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithoutImages(): void
    {
        $service = $this->constructEmpty(FileService::class, [], ['getFiles' => []]);
        $command = new GiveMePillsCommand(['test']);
        $command->fileService = $service;

        $command->run();
    }
}
