<?php

namespace Tests\Support\Module;

use Arslav\Bot\App;
use Arslav\Bot\Tests\Factories\VkApiMockFactory;
use Arslav\Bot\Tests\Helpers\VkChatHelper;
use Codeception\Module;
use Codeception\Stub as CodeceptionStub;
use Codeception\TestInterface;
use DigitalStar\vk_api\vk_api;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

class Stub extends Module
{
    /**
     * @param TestInterface $test
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function _before(TestInterface $test): void
    {
        $container = App::getContainer();
        $container->set(LoggerInterface::class, CodeceptionStub::constructEmpty(LoggerInterface::class));
        $container->set(vk_api::class, VkApiMockFactory::create());

        parent::_before($test);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function _after(TestInterface $test)
    {
        /** @var MockObject $mockedVkApi */
        $mockedVkApi = App::getVk();
        $mockedVkApi->__phpunit_verify();
        parent::_after($test); // TODO: Change the autogenerated stub
    }
}
