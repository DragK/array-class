<?php

namespace Tests;

use \PHPUnit\Framework\TestCase;
use DragK\ArrayClass;

final class ArrayTest extends TestCase
{
    public function testCanCreateArrayWithParameter()
    {
        // test array as parameter
        $arr = new ArrayClass([1,2,3]);
        $this->assertEquals([1, 2, 3], $arr->toArray());
    }

    public function testCanCreateEmptyArray()
    {
        $this->assertEquals([], (new ArrayClass())->toArray());
    }

    public function testGetArrayReturnArray()
    {
        $this->assertEquals([], (new ArrayClass())->toArray());
    }

    public function testCanConcatArrays()
    {
        $arrClass = new ArrayClass();
        $this->assertEquals(new ArrayClass([1]), $arrClass->concat([1]));
    }

    public function testCopyWithIn()
    {
        // one parameter
        $arr1 = new ArrayClass([1, 2, 3, 4, 5]);
        $result1 = $arr1->copyWithIn(-2);
        $this->assertEquals([1, 2, 3, 1, 2], $result1->toArray());

        // two parameters
        $arr2 = new ArrayClass([1, 2, 3, 4]);
        $result2 = $arr2->copyWithIn(0, 1);
        $this->assertEquals([2, 3, 4, 4], $result2->toArray());

        // two parameters: target > start
        $arr3 = new ArrayClass([1, 2, 3, 4, 5, 6, 7]);
        $result3 = $arr3->copyWithIn(2, 1);
        $this->assertEquals([1, 2, 2, 3, 4, 5, 6], $result3->toArray());

        // three parameters
        $arr4 = new ArrayClass([1, 2, 3, 4]);
        $result4 = $arr4->copyWithIn(0, 1, 2);
        $this->assertEquals([2, 2, 3, 4], $result4->toArray());

        // three parameters, all negative
        $arr5 = new ArrayClass([1, 2, 3, 4, 5]);
        $result5 = $arr5->copyWithIn(-2, -3, -1);
        $this->assertEquals([1, 2, 3, 3, 4], $result5->toArray());
    }

    public function testEvery()
    {
        $arr = new ArrayClass([1, 2, 3]);
        $result = $arr->every(function ($value) {
            return $value < 10;
        });

        $this->assertTrue($result);

        $result1 = $arr->every(function ($value) {
            return $value > 10;
        });
        $this->assertFalse($result1);
    }

    public function testFill()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        // one parameter
        $result = $arr->fill(7);
        $this->assertEquals([7, 7, 7, 7, 7], $result->toArray());

        // two parameters: startIndex
        $result = $result->fill(6, 2);
        $this->assertEquals([7, 7, 6, 6, 6], $result->toArray());

        // three parameters
        $result = $result->fill(10, 2, 4);
        $this->assertEquals([7, 7, 10, 10, 6], $result->toArray());

        // two parameters: endIndex

        $result = $result->fill(12, null, 1);
        $this->assertEquals([12, 7, 10, 10, 6], $result->toArray());
    }

    public function testFilter()
    {
        // int test
        $arr = new ArrayClass([1, 2, 3, 4, 5]);
        $result = $arr->filter(function ($value) {
            return $value >= 3;
        });

        $this->assertEquals([3, 4, 5], $result->toArray());

        // string test
        $arr = new ArrayClass(['spray', 'limit', 'elite', 'exuberant', 'destruction', 'present']);
        $result = $arr->filter(function ($value) {
            return strlen($value) >= 6;
        });

        $this->assertEquals(["exuberant", "destruction", "present"], $result->toArray());

        // test with key array
        $arr = new ArrayClass([
            'a' => 'spray',
            'b' => 'limit',
            'c' => 'elite',
            'd' => 'exuberant',
            'e' => 'destruction',
            'f' => 'present'
        ]);

        $result = $arr->filter(function ($value, $key) {
            return strlen($value) >= 6 && $key < 'e';
        });

        $this->assertEquals(['d' => "exuberant",], $result->toArray());
    }

    public function testFind()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        $result = $arr->find(function ($value) {
            return $value > 3;
        });

        $this->assertEquals(4, $result);
    }

    public function testFindIndex()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        // key exist
        $result = $arr->findIndex(function ($value) {
            return $value > 3;
        });
        $this->assertEquals(3, $result);

        // key doesn't exist
        $result = $arr->findIndex(function ($value) {
            return $value < 0;
        });
        $this->assertEquals(-1, $result);
    }

    public function testForEach()
    {
        $arr = new ArrayClass([1, 2, 3]);

        $arr->forEach(function (&$value) {
            $value += 1;
        });

        $this->assertEquals([2, 3, 4], $arr->toArray());
    }

    public function testIncludes()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        // value exist
        $result = $arr->includes(4);
        $this->assertEquals(true, $result);

        // value doesn't exist
        $result = $arr->includes(7);
        $this->assertEquals(false, $result);
    }

    public function testJoin()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        // test with string
        $result = $arr->join("-");
        $this->assertEquals("1-2-3-4-5", $result);

        // test with number
        $result = $arr->join(0);
        $this->assertEquals("102030405", $result);
    }

    public function testMap()
    {
        $arr = new ArrayClass([1, 2, 3]);
        // power of number
        $result = $arr->map(function ($value) {
            return $value ** 2;
        });
        $this->assertEquals([1, 4, 9], $result->toArray());

        // chaining a map function
        $result2 = $result->map(function ($value) {
            return $value * 10;
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

        $this->assertEquals([10, 40, 90], $result2->toArray());
    }

    public function testPop()
    {
        $arr = new ArrayClass([1, 2, 3]);

        // test returning last value from array
        $this->assertEquals(3, $arr->pop());

        // test removing last value from from array
        $this->assertEquals([1, 2], $arr->toArray());

        // test changing a length of array
        $this->assertEquals(2, $arr->length);
    }

    public function testPush()
    {
        $arr = new ArrayClass([1, 2, 3]);

        // test returning an array length
        $this->assertEquals(4, $arr->push(5));

        // test pushing a one value
        $this->assertEquals([1, 2, 3, 5], $arr->toArray());

        // test pushing a multiple values
        $arr->push(4, 6, 7);
        $this->assertEquals([1, 2, 3, 5, 4, 6, 7], $arr->toArray());

        // test returning an array length for multiple values
        $this->assertEquals(8, $arr->push([1, 2]));

        // test pushing a array
        $this->assertEquals([1, 2, 3, 5, 4, 6, 7, [1, 2]], $arr->toArray());
    }

    public function testReduce()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        // sum
        $result = $arr->reduce(function ($result, $value) {
            return $value + $result;
        }, 0);

        $this->assertEquals(15, $result);

        // multiply
        $result = $arr->reduce(function ($result, $value) {
            return $value * $result;
        }, 1);

        $this->assertEquals(120, $result);
    }

    public function testReverse()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        $result = $arr->reverse();
        $this->assertEquals([5, 4, 3, 2, 1], $result->toArray());
    }

    public function testShift()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        // test returning value
        $result = $arr->shift();
        $this->assertEquals(1, $result);

        // test changing length
        $this->assertEquals(4, $arr->length);

        // test whether element was removed
        $this->assertEquals([2, 3, 4, 5], $arr->toArray());
    }

    public function testSlice()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        // one parameter
        $result = $arr->slice(2);
        $this->assertEquals([3, 4, 5], $result->toArray());

        // two parameters
        $result = $arr->slice(2, 4);
        $this->assertEquals([3, 4], $result->toArray());

        // negative parameter
        $result = $arr->slice(-1, 4);
        $this->assertEquals([1, 2, 3, 4], $result->toArray());
    }

    public function testSome()
    {
        $arr = new ArrayClass([1, 2, 3, 4, 5]);

        $result = $arr->some(function ($value, $key) {
            return $key > 3 && $value > 3;
        });

        $this->assertTrue($result);
    }

    public function testSort()
    {
        $arr = new ArrayClass([1, 4, 2, 5, 3]);

        $result = $arr->sort();
        $this->assertEquals([1, 2, 3, 4, 5], $result->toArray());

        // reverse sort
        $result = $arr->sort()->reverse();
        $this->assertEquals([5, 4, 3, 2, 1], $result->toArray());
    }

    public function testSplice()
    {
        $arr = new ArrayClass([1, 4, 2, 5, 3]);

        // 1. two parameters
        $result = $arr->splice(0, 1);
        $this->assertEquals([4, 2, 5, 3], $result->toArray());

        // 2. two parameters, deleteCount greater then array length
        $arr1 = new ArrayClass([1, 4, 2, 5, 3]);
        $result = $arr1->splice(0, 10);
        $this->assertEquals([], $result->toArray());

        // 3. one parameter: startIndex = 0
        $arr2 = new ArrayClass([1, 4, 2, 5, 3]);
        $result = $arr2->splice(0);
        $this->assertEquals([], $result->toArray());

        // 4. two parameters: startIndex = 1, deleteCount = 10 (more then elements in array)
        $arr3 = new ArrayClass([1, 4, 2, 5, 3]);
        $result = $arr3->splice(1, 10);
        $this->assertEquals([1], $result->toArray());

        // 5. three parameters, one item
        $arr4 = new ArrayClass([1, 4, 2, 5, 3]);
        $result = $arr4->splice(1, 1, 10);
        $this->assertEquals([1, 10, 2, 5, 3], $result->toArray());

        // 6. three parameters, two items, one to delete
        $arr5 = new ArrayClass([1, 4, 2, 5, 3]);
        $result = $arr5->splice(1, 1, 10, 11);
        $this->assertEquals([1, 10, 11, 2, 5, 3], $result->toArray());


    }

    public function testToString()
    {
        $this->assertEquals('1,2', (string)(new ArrayClass([1, 2])));
        $this->assertEquals('1,2', (new ArrayClass([1, 2]))->__toString());
    }

    public function testUnshift()
    {
        $arr = new ArrayClass([1, 4, 2, 5, 3]);
        $result = $arr->unshift(100, 234, 343);

        // test adding items to array
        $this->assertEquals([100, 234, 343, 1, 4, 2, 5, 3], $arr->toArray());

        // test returning length of array
        $this->assertEquals(8, $result);
        $this->assertEquals($result, $arr->length);
    }

    public function testValues()
    {
        $arr = new ArrayClass([1, 4, 2, 5, 3]);
        $result = $arr->values();

        // check name
        $this->assertEquals("ArrayIterator", get_class($result));

        // check first value
        $this->assertEquals(1, $result->current());

        // check next value
        $result->next();
        $this->assertEquals(4, $result->current());
    }
}