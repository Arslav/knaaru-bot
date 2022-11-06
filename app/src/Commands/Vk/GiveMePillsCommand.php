<?php

namespace Arslav\KnaaruBot\Commands\Vk;

use Arslav\Bot\Vk\App;
use Arslav\KnaaruBot\Commands\Vk\Base\LimitedVkCommand;
use Arslav\KnaaruBot\Helpers\ArrayHelper;
use Arslav\KnaaruBot\Services\FileService;
use DI\Annotation\Inject;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class GiveMePillsCommand extends LimitedVkCommand
{
    /**
     * @Inject
     * @var FileService
     */
    public FileService $fileService;

    /**
     * @inheritDoc
     *
     * @throws VkApiException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
