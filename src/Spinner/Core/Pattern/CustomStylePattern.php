<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
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

    public function getEntries(OptionStyleMode $styleMode = OptionStyleMode::ANSI8): Traversable
    {
        yield from $this->pattern;
    }
}
