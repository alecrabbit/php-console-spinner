<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IStyle;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;

final class Style implements IStyle
{
    protected function __construct(
        public readonly string $sequence,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(mixed $s): IStyle
    {
        dump($s);
        if ($s instanceof IStyle) {
            return $s;
        }
        if (is_array($s)) {
            return new Style($s);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Unsupported frame element: [%s].',
                get_debug_type($s)
            )
        );
    }

    public function __toString(): string
    {
        return $this->sequence;
    }
}
