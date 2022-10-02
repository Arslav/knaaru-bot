<?php

namespace Arslav\KnaaruBot\Services;

use Arslav\Bot\App;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ChatInfoService
{
    public const CHAT_ID_OFFSET = 2000000000;

    /**
     * @param array $chat_ids
     *
     * @return mixed
     *
     * @throws VkApiException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getChatsInfoByIds(array $chat_ids): array
    {
        $peer_ids = array_map(fn($item) => $this->toPeerId($item), $chat_ids);

        $response = App::getVk()->request('messages.getConversationsById', [
            'peer_ids' => implode(',', $peer_ids),
        ]);

        return $response['items'];
    }

    /**
     * @param int $peer_id
     *
     * @return int
     */
    public function toChatId(int $peer_id): int
    {
        return $peer_id - self::CHAT_ID_OFFSET;
    }

    /**
     * @param int $chat_id
     *
     * @return int
     */
    public function toPeerId(int $chat_id): int
    {
        return $chat_id + self::CHAT_ID_OFFSET;
    }
}
