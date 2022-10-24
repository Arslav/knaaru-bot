<?php

namespace Arslav\KnaaruBot\Commands\Cli;

use Arslav\Bot\Cli\Command;
use Arslav\KnaaruBot\Services\ChatInfoService;
use Arslav\KnaaruBot\Services\CommandStatsService;
use DI\Annotation\Inject;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Команда выводящая список всех чатов к которым подключен бот
 */
class ChatListCommand extends Command
{
    /**
     * @Inject
     */
    public CommandStatsService $statsService;

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
        $chat_ids = $this->statsService->getAllChatIds();

        $chats = $this->chatInfoService->getChatsInfoByIds($chat_ids);

        if (empty($chats)) {
            echo "Активные чаты не найдены";
            return;
        }

        foreach ($chats as $chat) {
            $chat_id = $this->chatInfoService->toChatId($chat['peer']['id']);
            $members = $chat['chat_settings']['members_count'];
            echo "id: $chat_id, название: \"{$chat['chat_settings']['title']}\", число участников: $members" . PHP_EOL;
        }
    }
}
