<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

abstract class AFrameCollectionRevolver extends ARevolver implements IFrameCollectionRevolver
{
    protected iterable $frames = [];
    protected int $count = 0;
    protected int $offset = 0;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        iterable $frames,
        IInterval $interval,
    ) {
        parent::__construct($interval);
        foreach ($frames as $frame) {
            $this->addFrame($frame);
        }
        $this->assertIsNotEmpty();
    }

    protected function addFrame(IFrame $frame): void
    {
        $this->frames[] = $frame;
        $this->count++;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertIsNotEmpty(): void
    {
        if (0 === $this->count) {
            throw new InvalidArgumentException(
                sprintf('%s: Collection is empty.', static::class)
            );
        }
    }

    /**
     * @throws LogicException
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->throwCollectionIsImmutableException();
    }

    /**
     * @throws LogicException
     */
    protected function throwCollectionIsImmutableException(): never
    {
        throw new LogicException(
            sprintf('%s: Collection is immutable.', static::class)
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function offsetExists(mixed $offset): bool
    {
        $this->assertOffset($offset);
        return isset($this->frames[$offset]);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertOffset(mixed $offset): void
    {
        if (!is_int($offset)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s: Invalid offset type. Offset must be an integer, "%s" given.',
                    static::class,
                    get_debug_type($offset),
                )
            );
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function offsetGet(mixed $offset): IFrame
    {
        $this->assertOffset($offset);
        return
            $this->frames[$offset]
            ??
            throw new InvalidArgumentException(
                sprintf(
                    '%s: Undefined offset "%s".',
                    static::class,
                    $offset
                )
            );
    }

    /**
     * @throws LogicException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->throwCollectionIsImmutableException();
    }

    protected function next(float $dt = null): void
    {
        if (1 === $this->count || ++$this->offset === $this->count) {
            $this->offset = 0;
        }
    }

    protected function current(): IFrame
    {
        return $this->frames[$this->offset];
    }
}
