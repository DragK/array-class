<?php

declare(strict_types=1);

namespace dragk;

class ArrayClass 
{
    private $array = [];
    public $length;

    public function __construct(array $data) 
    {
        $this->array = $data;
        $this->setLength();
    }

    public function __call($name, $arguments)
    {
        if (is_callable($name)) {
            call_user_method($name, $arguments);
            $this->setLength();
            
        }echo $this->length;
    }

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

    public function toString() : string
    {
        $string = '';
        foreach ($this->array as $value) {
            $string .= "$value,";
        }        

        return rtrim($string, ",");
    }

    private function setLength() 
    {
        $this->length = sizeof($this->array);
    }
}