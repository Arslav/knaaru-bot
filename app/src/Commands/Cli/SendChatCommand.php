<?php

namespace Arslav\KnaaruBot\Commands\Cli;

use Arslav\Bot\Vk\App;
use Arslav\Bot\Cli\Command;
use Arslav\KnaaruBot\Services\ChatInfoService;
use DI\Annotation\Inject;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Команда отправляющая сообщение в чат. Пример: 1 Привет мир!
 */
class SendChatCommand extends Command
{
    /**
     * @Inject
     */
    public ChatInfoService $chatInfoService;

    /**
     * @return void
     *
     * @throws VkApiException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function execute(): void
    {
        $peer_id = $this->chatInfoService->toPeerId($this->args[0]);
        array_shift($this->args);
        $msg = implode(' ', $this->args);
        App::getVk()->sendMessage($peer_id, $msg);
    }
}
