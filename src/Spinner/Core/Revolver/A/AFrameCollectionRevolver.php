<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use ArrayAccess;

/**
 * @template T of IFrame
 * @template-implements ArrayAccess<int,T>
 */
abstract class AFrameCollectionRevolver extends ARevolver implements IFrameCollectionRevolver, ArrayAccess
{
    protected array $frames = [];
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
        /** @var IFrame $frame */
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
        self::assertOffsetType($offset);
        return isset($this->frames[$offset]);
    }

    /**
     * @param mixed $offset
     * @throws InvalidArgumentException
     */
    private static function assertOffsetType(mixed $offset): void
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
    public function offsetGet(mixed $offset): ?IFrame
    {
        self::assertOffsetType($offset);
        /** @var IFrame $value */
        $value =
            $this->frames[$offset]
            ??
            throw new InvalidArgumentException(
                sprintf(
                    '%s: Undefined offset "%s".',
                    static::class,
                    $offset
                )
            );
        /** @psalm-suppress InvalidReturnStatement */
        return
            $value;
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

    /** @psalm-suppress MixedInferredReturnType */
    protected function current(): IFrame
    {
        /** @psalm-suppress MixedReturnStatement */
        return $this->frames[$this->offset];
    }
}
