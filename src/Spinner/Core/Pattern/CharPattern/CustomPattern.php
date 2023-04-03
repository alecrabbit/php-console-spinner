<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class CustomPattern extends AReversiblePattern
{
    public function __construct(
        protected iterable $pattern,
        ?int $interval = null,
        bool $reversed = false
    ) {
        parent::__construct($interval, $reversed);
    }

    protected function pattern(): Traversable
    {
        yield from $this->pattern;
    }
}
