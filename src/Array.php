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

    public static function isArray($valueToCheck): bool
    {
        return is_array($valueToCheck);
    }

    public function append($value)
    {
        parent::append($value);
        $this->setLength();
    }

    public function toArray(): array
    {
        return (array)$this;
    }

    public function concat(array ...$array): ArrayClass
    {
        return new ArrayClass(array_merge($this->toArray(), ...$array));
    }

    public function copyWithIn(int $targetIndex, int $startIndex = 0, $endIndex = null): ArrayClass
    {
        $relativeTarget = $targetIndex >> 0;

        $to = $relativeTarget < 0 ?
            max($this->length + $relativeTarget, 0) :
            min($relativeTarget, $this->length);

        $relativeStart = $startIndex >> 0;

        $from = $relativeStart < 0 ?
            max($this->length + $relativeStart, 0) :
            min($relativeStart, $this->length);

        $relativeEnd = $endIndex ?? $this->length;

        $final = $relativeEnd < 0 ?
            max($this->length + $relativeEnd, 0) :
            min($relativeEnd, $this->length);

        $count = min($final - $from, $this->length - $to);

        $direction = 1;

        if ($from < $to && $to < ($from + $count)) {
            $direction = -1;
            $from += $count - 1;
            $to += $count - 1;
        }

        while ($count-- > 0) {
            if (array_key_exists($from, $this->toArray())) {
                $this[$to] = $this[$from];
            } else {
                $this->offsetUnset($to);
            }

            $from += $direction;
            $to += $direction;
        }

        return $this;
    }

    public function entries(): \ArrayIterator
    {
        $array = [];

        foreach ($this as $key => $value) {
            $array[] = [$key, $value];
        }

        return new \ArrayIterator($array);
    }

    public function every(callable $func): bool
    {
        $every = true;

        foreach ($this as $key => $value) {
            if (!$func($value, $key)) {
                $every = false;
                break;
            }
        }

        return $every;
    }

    public function filter(callable $func): ArrayClass
    {
        $newArr = [];

        foreach ($this as $key => $value) {
            if (!$func($value, $key)) {
                continue;
            }

            if (is_string($key)) {
                $newArr[$key] = $value;
            } else {
                $newArr[] = $value;
            }
        }
        unset($value);

        return new ArrayClass($newArr);
    }

    public function fill($value, int $startIndex = null, int $endIndex = null): ArrayClass
    {
        $newArr = $this->toArray();

        for ($i = (is_null($startIndex) ? 0 : $startIndex); $i < (is_null($endIndex) ? $this->length : $endIndex); $i++) {
            $newArr[$i] = $value;
        }

        return new ArrayClass($newArr);
    }

    public function find(callable $func)
    {
        $searchValue = null;

        foreach ($this as $key => $value) {
            if ($func($value, $key)) {
                $searchValue = $value;
                break;
            }
        }
        unset($value);

        return $searchValue;
    }

    public function findIndex(callable $func): int
    {
        $searchKey = -1;

        foreach ($this as $key => $value) {
            if ($func($value, $key)) {
                $searchKey = $key;
                break;
            }
        }
        unset($value);

        return $searchKey;
    }

    public function forEach(callable $func)
    {
        foreach ($this as $key => &$value) {
            $func($value);
        }
    }

    public function includes($value): bool
    {
        return isset($this[$value]) ? true : false;
    }

    public function indexOf($elementToSearch, int $startIndex = 0): int
    {
        for ($i = $startIndex; $i < $this->length; $i++) {
            if ($this[$i] === $elementToSearch) {
                return $i;
            }
        }

        return -1;
    }

    public function join(string $separator = ","): string
    {
        return implode($separator, $this->toArray());
    }

    public function keys(): \ArrayIterator
    {
        return new \ArrayIterator(array_keys($this->toArray()));
    }

    public function lastIndexOf($elementToSearch, int $startIndex = -1): int
    {
        $startIndex = ($startIndex === -1) || ($startIndex > $this->length) ? $this->length - 1 : $startIndex;
        for ($i = $startIndex; $i > 0; $i--) {
            if ($this[$i] === $elementToSearch) {
                return $i;
            }
        }

        return -1;
    }

    public function map(callable $func): ArrayClass
    {
        $newArr = [];
        foreach ($this as $key => $value) {
            $newArr[] = ($func($value, $key));
        }
        unset($value);

        return new ArrayClass($newArr);
    }

    public function push(...$data): int
    {
        foreach ($data as $value) {
            parent::append($value);
        }

        $this->setLength();

        return $this->length;
    }

    public function pop()
    {
        $value = $this[$this->length - 1];
        $this->offsetUnset($this->length - 1);
        $this->setLength();

        return $value;
    }

    public function reduce(callable $func, int $initValue = 0)
    {
        $result = $initValue;
        foreach ($this as $key => $value) {
            $result = $func($result, $value, $key);
        }
        unset($value);

        return $result;
    }

    public function reduceRight(callable $func, int $initialValue = null)
    {
        if ($initialValue === null && $this->length <= 0) {
            throw new \InvalidArgumentException("Array is empty and your initial value isn't a set up");
        }
        $previousValue = $initialValue ?? $this[$this->length - 1];

        $array = $this->reverse();
        for ($i = $this->length - 1; $i > 0; $i--) {
            $array->next();
            $previousValue = $func($previousValue, $array->current());

            if (!$array->valid()) {
                break;
            }
        }

        return $previousValue;
    }

    public function reverse(): ArrayClass
    {
        return new ArrayClass(array_reverse($this->toArray()));
    }

    public function shift()
    {
        $firstElement = $this[0];
        $this->offsetUnset(0);
        $this->setLength();
        $this->resetOffset();

        return $firstElement;
    }

    public function slice(int $startIndex = 0, int $endIndex = null): ArrayClass
    {
        $endIndex = is_null($endIndex) ? $this->length : $endIndex - abs($startIndex);

        return new ArrayClass(
            array_slice($this->toArray(), $startIndex, $endIndex)
        );
    }

    public function some(callable $func): bool
    {
        foreach ($this as $key => $value) {
            if ($func($value, $key)) {
                unset($value);
                return true;
            }
        }
        unset($value);

        return false;
    }

    public function sort(): ArrayClass
    {
        $arr = $this->toArray();
        sort($arr);

        return new ArrayClass($arr);
    }

    public function splice(int $startIndex, $deleteCount = null, ...$items): ArrayClass
    {
        $array = $this->toArray();
        $deleteCount = $deleteCount ?? $this->length;
        array_splice($array, $startIndex, $deleteCount, $items);

        return new ArrayClass($array);
    }

    public function __toString(): string
    {
        return $this->join();
    }

    public function unshift(bool $immutable = true, ...$items)
    {
        $array = $this->toArray();
        if ($immutable) {
            array_unshift($array, ...$items);
            return new ArrayClass($array);
        }

        $length = array_unshift($array, ...$items);
        $this->clearArray();
        $this->push(...$array);
        $this->setLength();
        $this->resetOffset();

        return $length;
    }

    private function clearArray()
    {
        foreach ($this->toArray() as $key => $value) {
            unset($this[$key]);
        }

        unset($value);
    }

    private function setLength()
    {
        $this->length = $this->count();
    }

    /**
     * Own reset keys function because built-in functions doesn't work with non-array object or array-like
     * @param bool
     */
    private function resetOffset()
    {
        for ($newKey = 0; $newKey < $this->length; $newKey++) {
            $this[$newKey] = $this[$this->key()];
            unset($this[$this->key()]);
        }
    }

    public function values(): \ArrayIterator
    {
        $array = [];
        foreach ($this as $value) {
            $array[] = $value;
        }
        return new \ArrayIterator($array);
    }
}