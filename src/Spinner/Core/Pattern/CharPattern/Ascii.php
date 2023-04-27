<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use ArrayObject;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class Ascii extends AReversiblePattern
{
    protected const INTERVAL = 300;
    protected const PATTERN = ['/', '|', '\\', '─'];

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
