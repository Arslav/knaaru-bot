<?php

use Arslav\KnaaruBot\Commands\Vk\EchoCommand;
use Arslav\KnaaruBot\Commands\Vk\GiveMePillsCommand;
use function DI\autowire;
use function DI\create;
use function DI\get;

return [
    EchoCommand::class => create()
        ->constructor([
            '^ыы+$',
            '^кря+$',
            '^ря+$',
            '^[аы]{2,}$'
        ]),
    GiveMePillsCommand::class => autowire()->constructor(['^сла+ва+(\,)? дай табле(тки+|то+к)\s?[(\!)(\?)]*$']),

    'vk-commands' => [
        get(EchoCommand::class),
        get(GiveMePillsCommand::class)
    ]
];
