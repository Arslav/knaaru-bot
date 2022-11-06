<?php

use Arslav\Bot\Telegram\Cli\SetWebhookCommand;
use Arslav\KnaaruBot\Commands\Cli\ChatListCommand;
use Arslav\KnaaruBot\Commands\Cli\EchoCommand;

use Arslav\KnaaruBot\Commands\Cli\SendChatCommand;

use function DI\autowire;
use function DI\create;
use function DI\get;

return [
    EchoCommand::class => create()->constructor(['echo']),
    ChatListCommand::class => autowire()->constructor(['chats']),
    SendChatCommand::class => autowire()->constructor(['send']),
    SetWebhookCommand::class => autowire()->constructor('set-webhook'),

    'cli-commands' => [
        get(EchoCommand::class),
        get(ChatListCommand::class),
        get(SendChatCommand::class),
        get(SetWebhookCommand::class),
    ],
];
