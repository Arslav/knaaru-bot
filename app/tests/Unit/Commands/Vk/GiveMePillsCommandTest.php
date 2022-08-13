<?php

namespace Tests\Unit\Commands\Vk;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Commands\Vk\GiveMePillsCommand;
use Arslav\KnaaruBot\Services\FileService;
use Codeception\Stub;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use DigitalStar\vk_api\vk_api;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\Support\UnitTester;

class GiveMePillsCommandTest extends Unit
{
    public UnitTester $tester;
    public Container $container;
    public mixed $stub;

    /**
     * @return void
     *
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     */
    protected function setUp(): void
    {
        $container = App::getContainer();
        $this->container = $container;

        /** @var $stub Stub */
        $this->stub = $container->get(vk_api::class);

        parent::setUp();
    }

    /**
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithImages(): void
    {
        $this->tester->sendMessage('слава дай таблетки');

        Stub::update($this->stub, [
            'sendImage' => Expected::once(),
        ]);

        $app = new App($this->container);
        $app->run();
    }

    /**
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithoutImages(): void
    {
        $this->tester->sendMessage('слава дай таблетки');
        $fileService = $this->constructEmpty(
            FileService::class,
            [],
            ['getFiles' => []]
        );

        /** @var GiveMePillsCommand $command */
        $command = $this->container->get(GiveMePillsCommand::class);
        $command->fileService = $fileService;

        /** @var $stub Stub */
        Stub::update($this->stub, [
            'reply' => Expected::once(),
        ]);

        $app = new App($this->container);
        $app->run();
    }
}
