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
     * @return array $this
     */
    public function getArray(): array;

    public function __toString(): string;

    /**
     * @param array[] ...$array
     * @return ArrayClass
     */
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

    public function append($value);

    public function push(...$data): int;

    public function pop();
}