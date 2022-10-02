<?php

namespace Arslav\KnaaruBot\Commands\Cli;

use Arslav\Bot\App;
use Arslav\Bot\Commands\Cli\Base\CliCommand;
use Arslav\KnaaruBot\Services\ChatInfoService;
use DI\Annotation\Inject;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Команда отправляющая сообщение в чат. Пример: 1 Привет мир!
 */
class SendChatCommand extends CliCommand
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
    public function run(): void
    {
        $peer_id = $this->chatInfoService->toPeerId($this->args[0]);
        array_shift($this->args);
        $msg = implode(' ', $this->args);
        App::getVk()->sendMessage($peer_id, $msg);
    }
}
