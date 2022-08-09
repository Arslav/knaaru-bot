<?php

namespace Arslav\KnaaruBot\Commands\Cli;

use Arslav\Bot\Commands\Cli\Base\CliCommand;

/**
 * Команда выводящая первый из переданных аргументов
 */
class EchoCommand extends CliCommand
{
    /**
     * @return void
     */
    public function run(): void
    {
        echo $this->args[0].PHP_EOL;
    }
}
