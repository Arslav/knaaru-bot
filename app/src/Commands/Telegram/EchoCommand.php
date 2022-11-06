<?php

namespace Arslav\KnaaruBot\Commands\Telegram;

use Arslav\Bot\Command;
use Arslav\Bot\Telegram\App;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class EchoCommand
 *
 * @package Arslav\KnaaruBot\Commands\Telegram
 */
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
    public function execute(): void
    {
        App::bot()->reply($this->message->getContent());
    }
}
