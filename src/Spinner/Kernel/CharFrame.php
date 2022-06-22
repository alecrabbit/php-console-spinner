<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\WidthDefiner;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Stringable;

final class CharFrame implements ICharFrame
{
    private const MAX_WIDTH = Defaults::MAX_WIDTH;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        public readonly string $sequence,
        public readonly int $sequenceWidth,
    ) {
        self::assert($this);
    }


    /**
     * @throws InvalidArgumentException
     */
    private static function assert(CharFrame $frame): void
    {
        if (0 > $frame->sequenceWidth) {
            throw new InvalidArgumentException(
                sprintf(
                    'Width must be a positive integer. [%s]',
                    $frame->sequenceWidth
                )
            );
        }
        if (self::MAX_WIDTH < WidthDefiner::define($frame->sequence)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given sequence is too wide. [%s]',
                    $frame->sequence
                )
            );
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(mixed $element, ?int $elementWidth): ICharFrame
    {
        if ($element instanceof ICharFrame) {
            return $element;
        }
        if (is_int($element) || is_float($element) || $element instanceof Stringable) {
            $element = (string)$element;
        }
        if (is_bool($element)) {
            $element = $element ? 'true' : 'false';
        }
        if (is_null($element)) {
            $element = 'null';
        }
        if (is_string($element)) {
            return new CharFrame($element, $elementWidth ?? WidthDefiner::define($element));
        }
        if (is_iterable($element)) {
            return self::createFromIterable($element, $elementWidth);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Unsupported frame element: [%s].',
                get_debug_type($element)
            )
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createFromIterable(iterable $f, ?int $elementWidth): ICharFrame
    {
        $a = [];
        $c = 0;
        foreach ($f as $e) {
            $a[$c++] = $e;
            if (2 <= $c) {
                break;
            }
        }
        if (array_key_exists(0, $a) && null !== $elementWidth) {
            return new CharFrame($f[0], $elementWidth);
        }
        if (array_key_exists(0, $a) && array_key_exists(1, $a)) {
            return new CharFrame($f[0], $f[1]);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Failed to extract frame object from element: [%s].',
                get_debug_type($f)
            )
        );
    }

    public function __toString(): string
    {
        return $this->sequence;
    }

    public function getChar(): string
    {
        return $this->sequence;
    }

    public function getWidth(): int
    {
        return $this->sequenceWidth;
    }

    public static function createEmpty(): static
    {
        // TODO: Implement createEmpty() method.
    }
}
