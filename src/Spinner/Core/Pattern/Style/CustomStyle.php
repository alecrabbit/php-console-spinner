<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class CustomStyle extends AStylePattern
{
    public function __construct(
        protected iterable $pattern,
        ?int $interval = null,
        protected ColorMode $colorMode = self::COLOR_MODE,
    ) {
        parent::__construct($interval);
    }

    protected function pattern(): Traversable
    {
        yield from $this->pattern;
    }

    public function getColorMode(): ColorMode
    {
        return $this->colorMode;
    }
}
