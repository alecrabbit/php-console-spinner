<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\StylePattern;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\A\AStylePattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class CustomStylePattern extends AStylePattern
{
    public function __construct(
        protected iterable $pattern,
        ?OptionStyleMode $styleMode = null,
        ?IInterval $interval = null,
        bool $reversed = false
    ) {
        parent::__construct($interval, $reversed, $styleMode);
    }

    protected function entries(): Traversable
    {
        yield from $this->pattern;
    }
}
