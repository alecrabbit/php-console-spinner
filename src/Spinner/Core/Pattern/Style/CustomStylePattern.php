<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class CustomStylePattern extends AStylePattern
{
    public function __construct(
        protected iterable $pattern,
        protected StyleMode $styleMode = self::STYLE_MODE,
        ?int $interval = null,
        bool $reversed = false
    ) {
        parent::__construct($interval, $reversed);
    }

//    public function __construct(
//        protected iterable $pattern,
//        ?int $interval = null,
//        bool $reversed = false,
//        protected StyleMode $styleMode = self::STYLE_MODE
//    ) {
//        parent::__construct($interval, $reversed);
//    }
    protected function pattern(): Traversable
    {
        yield from $this->pattern;
    }
}
