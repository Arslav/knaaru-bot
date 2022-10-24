<?php

namespace Arslav\KnaaruBot\Commands\Telegram;

use Arslav\Bot\Telegram\App;
use TelegramBot\Api\Exception;
use Arslav\Bot\Telegram\Command;
use TelegramBot\Api\InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EchoCommand extends Command
{
    /**
     * @inheritDoc
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        App::getTelegram()->sendMessage($this->chatId, $this->message);
    }
}
