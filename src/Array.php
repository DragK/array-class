<?php

declare(strict_types=1);

namespace DragK;


class ArrayClass extends \ArrayIterator implements ArrayInterface
{
    /**
     * @var int $length size of array
     */
    public $length;

    public function __construct(array $data = []) 
    {
        parent::__construct($data);
        $this->setLength();
    }

    /**
     * @inheritdoc
     */
    public function getArray(): array
    {
        return (array)$this;
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
     * @inheritdoc
     */
    public function concat(array ...$array): ArrayClass
    {
        return new ArrayClass(array_merge($this->getArray(), ...$array));
    }

    /**
     * @inheritdoc
     */
    public function map(callable $func): ArrayClass
    {
        $newArr = [];
        foreach ($this as $key => $value) {
            $newArr[] = ($func($value, $key));
        }

        return new ArrayClass($newArr);
    }

    /**
     * @inheritdoc
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

    public function pop()
    {
        $value = $this[$this->length - 1];
        unset($this[$this->length - 1]);
        $this->setLength();

        return $value;
    }

    private function setLength()
    {
        $this->length = $this->count();
    }
}