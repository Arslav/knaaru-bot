<?php

use Arslav\KnaaruBot\Services\ChatInfoService;
use Arslav\KnaaruBot\Services\CommandStatsService;
use Arslav\KnaaruBot\Services\FileService;
use Psr\Container\ContainerInterface;
use function DI\factory;

/** @var ContainerInterface $c */
return [
    CommandStatsService::class => factory(fn () => new CommandStatsService()),
    FileService::class => factory(fn () => new FileService()),
    ChatInfoService::class => factory(fn() => new ChatInfoService())
];
