<?php

namespace Tests\Unit\Helpers;

use Arslav\KnaaruBot\Helpers\ArrayHelper;
use Codeception\Test\Unit;

class ArrayHelperTest extends Unit
{
    public function testRandomSelect()
    {
        $array = ['test2', 'test1'];
        $item = ArrayHelper::randomSelect($array);
        $this->assertTrue(in_array($item, $array));
    }
}
