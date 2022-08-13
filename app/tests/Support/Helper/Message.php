<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Codeception\Module;
use stdClass;

class Message extends Module
{
    //TODO: Переписать на DTO
    public static stdClass $vkMessageData;

    public function sendMessage(string $message)
    {
        $dataArray = [
            'object' => [
                'peer_id' => 1,
                'text' => $message,
                'payload' => [],
                'from_id' => 1,
            ],
            'type' => 'message_new'
        ];
        self::$vkMessageData = json_decode(json_encode($dataArray), false);
    }

    /**
     * @return stdClass
     */
    public static function getVkMessageData(): stdClass
    {
        return self::$vkMessageData;
    }

}
