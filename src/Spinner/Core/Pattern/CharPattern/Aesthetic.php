<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\ACharPattern;
use ArrayObject;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class Aesthetic extends ACharPattern
{
    protected const INTERVAL = 80;

    protected const PATTERN = [
        '▰▱▱▱▱▱▱',
        '▰▰▱▱▱▱▱',
        '▰▰▰▱▱▱▱',
        '▰▰▰▰▱▱▱',
        '▱▰▰▰▰▱▱',
        '▱▱▰▰▰▰▱',
        '▱▱▱▰▰▰▰',
        '▱▱▱▱▰▰▰',
        '▱▱▱▱▱▰▰',
        '▱▱▱▱▱▱▰',
        '▱▱▱▱▱▱▱',
    ];

    public function __construct(
        ?int $interval = null,
        bool $reversed = false
    ) {
        parent::__construct(
            new ArrayObject(self::PATTERN),
            $interval ?? self::INTERVAL,
            $reversed
        );
    }
}
