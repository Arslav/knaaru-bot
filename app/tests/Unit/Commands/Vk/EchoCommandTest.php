<?php

namespace Tests\Unit\Commands\Vk;

use Arslav\Bot\App;
use Arslav\KnaaruBot\Commands\Vk\EchoCommand;
use Codeception\Stub;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EchoCommandTest extends Unit
{
    protected EchoCommand $command;

    /**
     * @return void
     */
    protected function _setUp(): void
    {
        $this->command = new EchoCommand(['test']);
        parent::_setUp();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function testRun()
    {
        Stub::update(App::getVk(), [
            'reply' => Expected::once(),
            'sendImage' => Expected::never(),
        ]);

        $this->command->run();
    }
}
