<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\CharPattern;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Pattern\Legacy\A\ACharPattern;
use Traversable;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class Snake extends ACharPattern
{
    protected const INTERVAL = 80;

    public function __construct(
        ?int $interval = null,
        bool $reversed = false
    ) {
        parent::__construct(
            interval: $interval ?? self::INTERVAL,
            reversed: $reversed
        );
    }

    /** @inheritDoc */
    public function getEntries(): Traversable
    {
        yield from [
            new CharFrame('⠏', 1),
            new CharFrame('⠛', 1),
            new CharFrame('⠹', 1),
            new CharFrame('⢸', 1),
            new CharFrame('⣰', 1),
            new CharFrame('⣤', 1),
            new CharFrame('⣆', 1),
            new CharFrame('⡇', 1),
        ];
    }
}
