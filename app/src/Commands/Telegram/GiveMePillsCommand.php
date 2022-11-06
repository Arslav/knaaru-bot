<?php

namespace Arslav\KnaaruBot\Commands\Telegram;

use Arslav\Bot\Command;
use Arslav\Bot\Telegram\App;
use TelegramBot\Api\Exception;
use Arslav\KnaaruBot\Helpers\ArrayHelper;
use Arslav\KnaaruBot\Services\FileService;
use DI\Annotation\Inject;
use Psr\Container\NotFoundExceptionInterface;
use TelegramBot\Api\InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;

class GiveMePillsCommand extends Command
{
    /**
     * @Inject
     * @var FileService
     */
    public FileService $fileService;

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
        $pills = $this->fileService->getFiles('/public/images/pills');

        if (empty($pills)) {
            App::bot()->reply('Таблетки кончились');
            return;
        }

        App::bot()->sendPhoto($this->message->getChatId(), ArrayHelper::randomSelect($pills));
    }
}
