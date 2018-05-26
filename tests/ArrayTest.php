<?php

use \PHPUnit\Framework\TestCase;
use DragK\ArrayClass;

final class ArrayTest extends TestCase
{
    public function testCanCreateArrayWithParameter()
    {
        $arr = new ArrayClass([1,2,3]);
        $this->assertEquals([1,2,3], $arr->getArray());
    }

    public function testCanCreateEmptyArray()
    {
        $this->assertEquals([], (new ArrayClass())->getArray());
    }
}