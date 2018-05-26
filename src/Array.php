<?php

declare(strict_types=1);

namespace DragK;

class ArrayClass 
{
    private $array = [];
    public $length;

    public function __construct(array $data = null) 
    {
        $this->array = !is_null($data) ? $data : [];
        $this->setLength();
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function __toString()
    {
        $string = '';
        foreach ($this->array as $value) {
            $string .= "$value,";
        }        

        return rtrim($string, ",");
    }

    /**
     * 
     * @param callable $func first parametr is a $value, second parametr is a key, 
     *                       other parameters is optional, recommand using 'use' keyword 
     *                       for additional parameters or if you don't want use data from array 
     *                       but you have to pass some variable
     */
    public function map(callable $func) 
    {
        $newArr = new ArrayClass();
        foreach ($this->array as $key => $value) {
            $newArr->push($func($value, $key));
        }

        return $newArr;
    }
    /**
     * If you want modify a value in array you have to add a reference(&) in your callback function
     * 
     * @param callable $func  
     */
    public function forEach(callable $func) 
    {
        foreach ($this->array as $key => &$value) {
            $func($value);
        }
    }

    public function push($data) : int 
    { 
        if (is_array($data)) {
            foreach ($data as $value) {
                $this->array[] = $value;                
            }
        } else {
            $this->array[] = $data;
        } 

        $this->setLength();

        return $this->length;
    }

    public function pop()
    {
        $value = array_pop($this->array);
        $this->setLength();
        
        return $value;
    }

    private function setLength() 
    {
        $this->length = sizeof($this->array);
    }
}