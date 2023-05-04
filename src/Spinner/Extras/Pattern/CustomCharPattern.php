<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Pattern;

use AlecRabbit\Spinner\Core\Pattern\A\ACharPattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class CustomCharPattern extends ACharPattern
{
    protected const INTERVAL = 1000;

    public function __construct(
        protected iterable $pattern,
        ?int $interval = null,
        bool $reversed = false
    ) {
        parent::__construct(
            $this->entries(),
            $interval ?? self::INTERVAL,
            $reversed
        );
    }

    protected function entries(): Traversable
    {
        yield from $this->pattern;
    }
}
