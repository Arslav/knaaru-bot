<?php

use Arslav\KnaaruBot\Commands\Telegram\EchoCommand;
use Arslav\KnaaruBot\Commands\Telegram\HelloCommand;
use Arslav\KnaaruBot\Commands\Telegram\GiveMePillsCommand;
use function DI\autowire;
use function DI\create;
use function DI\get;

return [
    HelloCommand::class => create(HelloCommand::class)->constructor('^hello$'),
    EchoCommand::class => create(EchoCommand::class)
        ->constructor([
            '^ыы+$',
            '^кря+$',
            '^ря+$',
            '^[аы]{2,}$'
        ]),
    GiveMePillsCommand::class => autowire()->constructor(['^сла+ва+(\,)? дай табле(тки+|то+к)\s?[(\!)(\?)]*$']),

    'telegram-commands' => [
        get(HelloCommand::class),
        get(EchoCommand::class),
        get(GiveMePillsCommand::class),
    ]
];
