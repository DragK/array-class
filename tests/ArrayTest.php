<?php
namespace Tests;

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

    public function testGetArrayReturnArray()
    {
        $this->assertEquals([], (new ArrayClass())->getArray());
    }

    public function testToString()
    {
        $this->assertEquals('1,2', (string)(new ArrayClass([1, 2])));
        $this->assertEquals('1,2', (new ArrayClass([1, 2]))->__toString());
    }

    public function testCanConcatArrays()
    {
        $arrClass = new ArrayClass();
        $this->assertEquals(new ArrayClass([1]), $arrClass->concat([1]));
    }

    public function testMap()
    {
        $arr = new ArrayClass([1, 2, 3]);
        // power of number
        $result = $arr->map(function($value) {
            return $value**2;
        });
        $this->assertEquals([1, 4, 9], $result->getArray());

        // chaining a map function
        $result2 = $result->map(function($value){
           return $value*10;
        });
        /**
         * Example above is equal to:
         * $arr
         * ->map(function($value) {
         *   return $value**2;
         * })
         * ->map(function($value){
         *   return $value*10;
         * });
         */

        $this->assertEquals([10, 40, 90], $result2->getArray());
    }

    public function testForEach()
    {
        $arr = new ArrayClass([1, 2, 3]);

        $arr->forEach(function (&$value) {
            $value += 1;
        });

        $this->assertEquals([2, 3, 4], $arr->getArray());
    }

    public  function testPush()
    {
        $arr = new ArrayClass([1, 2, 3]);

        // test returning an array length
        $this->assertEquals(4, $arr->push(5));

        // test pushing a one value
        $this->assertEquals([1, 2, 3, 5], $arr->getArray());

        // test pushing a multiple values
        $arr->push(4, 6, 7);
        $this->assertEquals([1, 2, 3, 5, 4, 6, 7], $arr->getArray());

        // test returning an array length for multiple values
        $this->assertEquals(8, $arr->push([1, 2]));

        // test pushing a array
        $this->assertEquals([1, 2, 3, 5, 4, 6, 7, [1, 2]], $arr->getArray());
    }

    public function testPop()
    {
        $arr = new ArrayClass([1, 2, 3]);

        // test returning last value from array
        $this->assertEquals(3, $arr->pop());

        // test removing last value from from array
        $this->assertEquals([1, 2], $arr->getArray());

        // test changing a length of array
        $this->assertEquals(2, $arr->length);
    }
}