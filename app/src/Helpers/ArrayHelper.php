<?php

namespace Arslav\KnaaruBot\Helpers;

class ArrayHelper
{
    /**
     * @param array $collection
     *
     * @return mixed
     */
    public static function randomSelect(array $collection): mixed
    {
        $key = array_rand($collection);

        return $collection[$key];
    }
}
