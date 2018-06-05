<?php

declare(strict_types=1);


namespace DragK;


/**
 * Interface ArrayInterface
 * @package DragK
 */
interface ArrayInterface
{

    /**
     * Determines whether the passed value is an Array.
     * @param $valueToCheck
     * @return bool
     */
    public static function isArray($valueToCheck): bool;

    /**
     * Extends parent method of ArrayIterator class
     * @param mixed $value
     */
    public function append($value);

    /**
     * Faster way to return array than by getArrayCopy()
     */
    public function toArray(): array;

    /**
     * Merge two or more arrays. This method does not change the existing arrays, but instead returns a new array.
     * @param array[] ...$array
     * @return ArrayClass
     */
    public function concat(array ...$array): ArrayClass;

    /**
     * Shallow copies part of an array to another location in the same array and returns it, without modifying its size.
     * @param int $targetIndex
     * @param int $startIndex
     * @param null $endIndex
     * @return ArrayClass
     */
    public function copyWithIn(int $targetIndex, int $startIndex = 0, $endIndex = null): ArrayClass;

    /**
     * Returns a new Array Iterator object that contains the key/value pairs for each index in the array.
     * @return \ArrayIterator
     */
    public function entries(): \ArrayIterator;

    /**
     * Tests whether all elements in the array pass the test implemented by the provided function.
     * @param callable $func
     * @return bool
     */
    public function every(callable $func): bool;

    /**
     * Fills all the elements of an array from a start index to an end index with a static value.
     * The end index is not included.
     * @param mixed $value
     * @param int $startIndex
     * @param int $endIndex
     * @return ArrayClass
     */
    public function fill($value, int $startIndex = null, int $endIndex = null): ArrayClass;

    /**
     * Creates a new array with all elements that pass the test implemented by the provided function.
     * @param callable $func
     * @return ArrayClass
     */
    public function filter(callable $func): ArrayClass;

    /**
     * Returns the value of the first element in the array that satisfies the provided testing function.
     * Otherwise null is returned.
     * @param callable $func
     * @return mixed | null
     */
    public function find(callable $func);

    /**
     * Returns the index of the first element in the array that satisfies the provided testing function.
     * Otherwise -1 is returned
     * @param callable $func
     * @return int index|-1
     */
    public function findIndex(callable $func): int;

    /**
     * Executes a provided function once for each array element.
     * If you want modify a value from array or outside a function you have to add a reference(&)     *
     * @param callable $func
     */
    public function forEach(callable $func);

    /**
     * Determines whether an array includes a certain element, returning true or false as appropriate.
     * @param $value
     * @return bool
     */
    public function includes($value): bool;

    /**
     * Returns the first index at which a given element can be found in the array, or -1 if it is not present.
     * @param mixed $elementToSearch
     * @param int $startIndex
     * @return int index|-1
     */
    public function indexOf($elementToSearch, int $startIndex = 0): int;

    /**
     * Joins all elements of an array (or an array-like object) into a string and returns this string.
     * @param $separator
     * @return string
     */
    public function join(string $separator): string;

    /**
     * Returns a new Array Iterator object that contains the keys for each index in the array.
     * @return \ArrayIterator
     */
    public function keys(): \ArrayIterator;

    /**
     * Returns the last index at which a given element can be found in the array, or -1 if it is not present.
     * The array is searched backwards, starting at startIndex.
     * @param $elementToSearch
     * @param int $startIndex
     * @return int index|-1
     */
    public function lastIndexOf($elementToSearch, int $startIndex = -1): int;

    /**
     * Creates a new array with the results of calling a provided function on every element in the calling array.
     * @param callable $func first parametr of $func is a $value, second is a key and both so optional but
     *                       I recommand using 'use' keyword
     *                       for additional parameters or if you don't want use data from array
     *                       but you have to pass some variable
     * @return ArrayClass $newArray
     */
    public function map(callable $func): ArrayClass;

    /**
     * Remove last element of array and return it. Changing length of array
     * @return mixed
     */
    public function pop();

    /**
     * Adds one or more elements to the end of an array and returns the new length of the array.
     * @param array ...$data
     * @return int $this->length
     */
    public function push(...$data): int;

    /**
     * Applies a function against an accumulator and each element in the array (from left to right)
     * to reduce it to a single value.
     * @param callable $func
     * @param int $initValue Optional
     * @return int
     */
    public function reduce(callable $func, int $initValue = 0);

    /**
     * Method applies a function against an accumulator and each value of the array (from right-to-left)
     * to reduce it to a single value.
     * @param callable $func
     * @param int|null $initialValue
     * @return mixed
     */
    public function reduceRight(callable $func, int $initialValue = null);

    /**
     * Reverses an array in place. The first array element becomes the last,
     * and the last array element becomes the first.
     * @return ArrayClass
     */
    public function reverse(): ArrayClass;

    /**
     * Removes the first element from an array and returns that removed element.
     * This method changes the length of the array.
     * @return mixed
     */
    public function shift();

    /**
     * Returns a shallow copy of a portion of an array into a new array object selected
     * from begin to end (end not included). The original array will not be modified.
     * @param int $startIndex
     * @param int|null $endIndex
     * @return ArrayClass
     */
    public function slice(int $startIndex = 0, int $endIndex = null): ArrayClass;

    /**
     * Tests whether at least one element in the array passes the test implemented by the provided function.
     * @param callable $func
     * @return bool
     */
    public function some(callable $func): bool;

    /**
     * Returns new sorted array object
     * @return ArrayClass
     */
    public function sort(): ArrayClass;

    /**
     * Returns new array with elements which was added or replaced
     * @param int $startIndex
     * @param int|null $deleteCount
     * @param array ...$items
     * @return ArrayClass
     */
    public function splice(int $startIndex, $deleteCount = null, ...$items): ArrayClass;

    /**
     * @example ['a', 'b', 'c'] --> "a,b,c"
     * @return string
     */
    public function __toString(): string;

    /**
     * Returns a new array Iterator object that contains the values for each index in the array.
     * @return \ArrayIterator
     */
    public function values(): \ArrayIterator;

    /**
     * Adds one or more elements to the beginning of an array:
     * if $immutable is true: return new array object. I recommend that way.
     * if $immutable is false: returns the new length of the array. **MUCH more time expensive**.
     *
     * Not exactly implementation of JS Array
     * @param bool $immutable
     * @param array ...$items
     * @return mixed
     */
    public function unshift(bool $immutable = true, ...$items);
}