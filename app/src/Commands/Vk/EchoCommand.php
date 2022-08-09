<?php

namespace Arslav\KnaaruBot\Commands\Vk;

use Arslav\Bot\App;
use Arslav\Bot\Commands\Vk\Base\VkCommand;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EchoCommand extends VkCommand
{
    /**
     * @inheritDoc
     *
     * @throws VkApiException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        App::getVk()->reply($this->message);
    }
}
