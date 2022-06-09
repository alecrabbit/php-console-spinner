<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use Stringable;

final class Frame implements IFrame
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        public readonly string $sequence,
        public readonly int $sequenceWidth,
    ) {
        self::assertSequence($sequence);
        self::assertSequenceWidth($sequenceWidth);
    }

    private static function assertSequence(string $sequence): void
    {
        // TODO (2022-06-09 16:12) [Alec Rabbit]: Implement if needed
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertSequenceWidth(int $width): void
    {
        if (0 > $width) {
            throw new InvalidArgumentException('Width must be a positive integer.');
        }
        // TODO (2022-06-07 16:13) [Alec Rabbit]: check other conditions
    }

    public function __toString(): string
    {
        return $this->sequence;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(mixed $f): IFrame
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
            return new Frame($f, WidthQualifier::qualify($f));
        }
        if (is_iterable($f)) {
            return self::createFromIterable($f);
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
    private static function createFromIterable(iterable $f): IFrame
    {
        $a = [];
        $c = 0;
        foreach ($f as $e) {
            $a[$c++] = $e;
            if(2 <= $c) {
                break;
            }
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
}
