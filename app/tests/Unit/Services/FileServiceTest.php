<?php

namespace Tests\Unit\Services;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Services\FileService;
use Codeception\Test\Unit;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;

class FileServiceTest extends Unit
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        $container = App::getContainer();
        $container->set(LoggerInterface::class, $this->constructEmpty(LoggerInterface::class));
        parent::setUp();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testGetFiles()
    {
        $service = new FileService();
        $files = $service->getFiles('/tests/Support/Data/Files');
        $this->assertIsArray($files);
        $this->assertNotEmpty($files);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testGetFilesException()
    {
        $service = new FileService();
        $files = $service->getFiles('/tests/Support/Data/NotExist');
        $this->assertEmpty($files);
    }
}
