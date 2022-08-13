<?php

use Arslav\KnaaruBot\Services\CommandStats;
use Arslav\KnaaruBot\Services\FileService;
use Psr\Container\ContainerInterface;
use function DI\factory;

/** @var ContainerInterface $c */
return [
    CommandStats::class => Factory(fn () => new CommandStats()),
    FileService::class => Factory(fn () => new FileService()),
];
