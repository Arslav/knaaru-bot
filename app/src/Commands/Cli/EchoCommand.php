<?php

namespace Arslav\KnaaruBot\Commands\Cli;

use Arslav\Bot\Cli\Command;

/**
 * Команда выводящая первый из переданных аргументов
 */
class EchoCommand extends Command
{
    /**
     * @return void
     */
    public function run(): void
    {
        echo $this->args[0].PHP_EOL;
    }
}
