<?php

namespace Arslav\KnaaruBot\Commands\Vk;

use Arslav\Bot\Vk\App;
use DigitalStar\vk_api\VkApiException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Arslav\KnaaruBot\Commands\Vk\Base\LimitedVkCommand;

/**
 * Class EchoCommand
 *
 * @package Arslav\KnaaruBot\Commands\Vk
 */
class EchoCommand extends LimitedVkCommand
{
    /**
     * @inheritDoc
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws VkApiException
     */
    public function execute(): void
    {
        App::bot()->reply($this->message->getContent());
    }
}
