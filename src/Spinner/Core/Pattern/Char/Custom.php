<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

final class Custom extends AReversiblePattern
{
    public function __construct(
        protected iterable $pattern,
        ?int $interval = null,
        bool $reversed = false
    ) {
        parent::__construct($interval, $reversed);
    }


    protected function pattern(): iterable
    {
        yield from $this->pattern;
    }
}