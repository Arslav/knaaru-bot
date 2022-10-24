<?php

namespace Arslav\KnaaruBot\Commands\Telegram;

use CURLFile;
use Arslav\Bot\Telegram\App;
use TelegramBot\Api\Exception;
use Arslav\Bot\Telegram\Command;
use Arslav\KnaaruBot\Helpers\ArrayHelper;
use Arslav\KnaaruBot\Services\FileService;
use DI\Annotation\Inject;
use TelegramBot\Api\InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
    public function run(): void
    {
        $pills = $this->fileService->getFiles('/public/images/pills');

        if (empty($pills)) {
            App::getTelegram()->sendMessage($this->chatId, 'Таблетки кончились');
            return;
        }
        App::getTelegram()->sendPhoto($this->chatId, new \CURLFile(ArrayHelper::randomSelect($pills)));
    }
}
