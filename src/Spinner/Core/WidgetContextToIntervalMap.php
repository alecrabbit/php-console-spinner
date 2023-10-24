<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IWidgetContextToIntervalMap;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;
use WeakMap;

final readonly class WidgetContextToIntervalMap implements IWidgetContextToIntervalMap
{

    public function __construct(
        protected ArrayAccess&Countable&IteratorAggregate $map = new WeakMap(),
    ) {
    }

    public function getIterator(): Traversable
    {
        foreach ($this->map as $key => $value) {
            if ($value === false) {
                $value = null;
            }
            yield $key => $value;
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        if (!$offset instanceof IWidgetContext) {
            return false;
        }
        return $this->map->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): ?IInterval
    {
        $this->assertOffset($offset);

        if ($this->map->offsetGet($offset) === false) {
            return null;
        }

        return $this->map->offsetGet($offset);
    }

    private function assertOffset(mixed $offset): void
    {
        if (!$offset instanceof IWidgetContext) {
            throw new InvalidArgumentException('Invalid offset type.');
        }
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->assertOffset($offset);
        $this->assertValue($value);

        $this->map->offsetSet(
            $offset,
            $value ?? false
        );
    }

    private function assertValue(mixed $value): void
    {
        if (null === $value) {
            return;
        }
        if (!$value instanceof IInterval) {
            throw new InvalidArgumentException('Invalid value type.');
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->assertOffset($offset);

        $this->map->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->map->count();
    }
}
