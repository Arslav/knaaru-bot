<?php

use Arslav\Bot\App;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

/**
 * @param float $chance
 *
 * @return bool
 */
function checkChance(float $chance): bool
{
    return rand(0,100) < $chance * 100;
}

/**
 * @param string $string
 * @param bool $capitalizeFirstCharacter
 *
 * @return string
 */
function snakeToCamelCase(string $string, bool $capitalizeFirstCharacter = true): string
{
    $str = str_replace('_', '', ucwords($string, '_'));
    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }

    return $str;
}

