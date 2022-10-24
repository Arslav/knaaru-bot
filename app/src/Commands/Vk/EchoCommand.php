<?php

namespace Arslav\KnaaruBot\Commands\Vk;

use Arslav\Bot\Vk\App;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Arslav\KnaaruBot\Commands\Vk\Base\LimitedVkCommand;

class EchoCommand extends LimitedVkCommand
{
    /**
     * @inheritDoc
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws VkApiException
     */
    public function run(): void
    {
        App::getVk()->reply($this->message);
    }
}
