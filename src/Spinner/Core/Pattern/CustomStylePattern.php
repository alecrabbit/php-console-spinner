<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Core\Pattern\StylePattern\A\AStylePattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class CustomStylePattern extends AStylePattern
{
    public function __construct(
        protected iterable $pattern,
        ?int $interval = null,
        bool $reversed = false,
    ) {
        parent::__construct(
            interval: $interval,
            reversed: $reversed,
        );
    }

    public function getEntries(): Traversable
    {
        yield from $this->pattern;
    }
}
