<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;

final class Frame implements IFrame
{
    public function __construct(
        public readonly string $sequence,
        public readonly int $sequenceWidth,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(mixed $f): IFrame
    {
        if ($f instanceof IFrame) {
            return $f;
        }
        if (is_int($f) || is_float($f) || is_object($f)) {
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
