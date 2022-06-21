<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

abstract class ACollection implements Countable, IteratorAggregate
{
    protected iterable $elements = [];
    protected int $count = 0;
    protected int $index = 0;

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct(iterable $elements)
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        $this->assertIsNotEmpty();
    }

    public function getIterator(): Traversable
    {
        return
            new ArrayIterator($this->elements);
    }

    public function count(): int
    {
        return $this->count;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function addElement(mixed $element): void
    {
        self::assertElement($element, static::getElementClass());
        $this->elements[] = $element;
        $this->count++;
    }

    abstract protected static function getElementClass(): string;

    /**
     * @throws InvalidArgumentException
     */
    protected static function assertElement(mixed $element, string $class): void
    {
        if (!$element instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('Element must be instance of %s', $class)
            );
        }
    }

    /**
     * @throws RuntimeException
     */
    protected function assertIsNotEmpty(): void
    {
        if (0 === $this->count) {
            throw new RuntimeException(
                'Collection is empty.'
            );
        }
    }

    protected function nextElement(): mixed
    {
        if (1 === $this->count) {
            return $this->elements[0];
        }
        if (++$this->index === $this->count) {
            $this->index = 0;
        }
        return $this->elements[$this->index];
    }
}
