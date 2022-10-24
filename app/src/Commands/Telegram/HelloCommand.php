<?php

namespace Arslav\KnaaruBot\Commands\Telegram;

use Arslav\Bot\Telegram\App;
use Arslav\Bot\Telegram\Command;

class HelloCommand extends Command
{

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        App::getTelegram()->sendMessage($this->chatId, 'veritas aequitas' . $this->args[0]);
    }
}
