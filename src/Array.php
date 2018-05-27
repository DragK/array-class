<?php

declare(strict_types=1);

namespace DragK;

use phpDocumentor\Reflection\Types\Mixed_;


class ArrayClass extends \ArrayIterator
{
    public $length;

    public function __construct(array $data = []) 
    {
        parent::__construct($data);
        $this->setLength();
    }

    public function getArray(): array
    {
        return $this->getArrayCopy();
    }

    public function __toString(): string
    {
        $string = '';
        foreach ($this->getArrayCopy() as $value) {
            $string .= "$value,";
        }        

        return rtrim($string, ",");
    }

    /**
     * @param array[] ...$array
     * @return ArrayClass
     */
    public function concat(array ...$array): ArrayClass
    {
        return new ArrayClass(array_merge($this->getArray(), ...$array));
    }

    /**
     * 
     * @param callable $func first parametr of $func is a $value, second is a key and both so optional but 
     *                       I recommand using 'use' keyword 
     *                       for additional parameters or if you don't want use data from array 
     *                       but you have to pass some variable
     * @return ArrayClass $newArray
     */
    public function map(callable $func): ArrayClass
    {
        $newArr = new ArrayClass();
        foreach ($this->getArray() as $key => $value) {
            $newArr->push($func($value, $key));
        }

        return $newArr;
    }

    /**
     * If you want modify a value from array or outside a function you have to add a reference(&)
     * 
     * @param callable $func  
     */
    public function forEach(callable $func) 
    {
        foreach ($this as $key => &$value) {
            $func($value);
        }
    }

    public function append($value)
    {
        parent::append($value);
        $this->setLength();
    }

    public function push(...$data) : int
    {
        foreach($data as $value) {
            $this->append($value);
        }

        return $this->length;
    }

    public function pop(): Mixed_
    {
        $value = array_pop($this->getArrayCopy());
        $this->setLength();
        
        return $value;
    }

    private function setLength() 
    {
        $this->length = sizeof($this->getArrayCopy());
    }
}