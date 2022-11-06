<?php

namespace Arslav\KnaaruBot\Commands\Telegram;

use Arslav\Bot\Command;
use Arslav\Bot\Telegram\App;

class HelloCommand extends Command
{
    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        App::bot()->reply('veritas aequitas' . $this->args[0]);
    }
}
