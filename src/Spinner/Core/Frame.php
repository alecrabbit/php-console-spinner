<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use Stringable;

final class Frame implements IFrame
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
    private static function assert(Frame $frame): void
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
    public static function create(mixed $f, ?int $elementWidth): IFrame
    {
        if ($f instanceof IFrame) {
            return $f;
        }
        if (is_int($f) || is_float($f) || $f instanceof Stringable) {
            $f = (string)$f;
        }
        if (is_bool($f)) {
            $f = $f ? 'true' : 'false';
        }
        if (is_null($f)) {
            $f = 'null';
        }
        if (is_string($f)) {
            return new Frame($f, $elementWidth ?? WidthDefiner::define($f));
        }
        if (is_iterable($f)) {
            return self::createFromIterable($f, $elementWidth);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Unsupported frame element: [%s].',
                get_debug_type($f)
            )
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createFromIterable(iterable $f, ?int $elementWidth): IFrame
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
            return new Frame($f[0], $elementWidth);
        }
        if (array_key_exists(0, $a) && array_key_exists(1, $a)) {
            return new Frame($f[0], $f[1]);
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
}
