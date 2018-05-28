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
     * Faster way to return array than by getArrayCopy()
     */
    public function getArray(): array;

    public function __toString(): string;

    public function concat(array ...$array): ArrayClass;

    /**
     *
     * @param callable $func first parametr of $func is a $value, second is a key and both so optional but
     *                       I recommand using 'use' keyword
     *                       for additional parameters or if you don't want use data from array
     *                       but you have to pass some variable
     * @return ArrayClass $newArray
     */
    public function map(callable $func): ArrayClass;

    /**
     * If you want modify a value from array or outside a function you have to add a reference(&)
     *
     * @param callable $func
     */
    public function forEach(callable $func);

    /**
     * extends parent method of ArrayIterator class
     * @param mixed $value
     * @return mixed
     */
    public function append($value);

    /**
     * Add elements to array and return new length of array
     * @param array ...$data
     * @return int $this->length
     */
    public function push(...$data): int;

    /**
     * Remove last element of array and return it. Changing length of array
     * @return mixed
     */
    public function pop();

    public function filter(callable $func): ArrayClass;

    /**
     * @param mixed $value
     * @param int $startIndex
     * @param int $endIndex
     * @return ArrayClass
     */
    public function fill($value, $startIndex = null, $endIndex = null): ArrayClass;

    /**
     * @param callable $func
     * @param int $initValue
     * @return int
     */
    public function reduce(callable $func, $initValue = 0);
}