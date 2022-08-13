<?php

use Arslav\Bot\App;
use Codeception\Stub\Expected;
use Codeception\Stub;
use DigitalStar\vk_api\vk_api;
use Psr\Log\LoggerInterface;
use Tests\Support\Helper\Message;

$_ENV['DB_NAME']='test';

$container = require_once __DIR__ . '/../bootstrap.php';

$container->set(LoggerInterface::class, Stub::constructEmpty(LoggerInterface::class));
$container->set(vk_api::class, Stub::constructEmpty(
    vk_api::class,
    [null, null],
    [
        'initVars' => function(&$id, &$message) {
            $data = Message::getVkMessageData();
            $id = $data->object->peer_id;
            $message = $data->object->text;
            return $data;
        }
    ]
));

return new App($container);
