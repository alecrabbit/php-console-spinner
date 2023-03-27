<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use ArrayObject;
use Traversable;

abstract class AMultiModeStylePattern extends AStylePattern
{
    protected const PATTERN = ['#000000'];

    /** @var array<int,array<int, string>> */
    protected const MULTI_PATTERN = [
        StyleMode::ANSI4->value => ['#FF0000'],
        StyleMode::ANSI8->value => ['#00FF00'],
        StyleMode::ANSI24->value => ['#0000FF'],
    ];

    public function __construct(
        ?int $interval = null,
        bool $reversed = false,
        protected StyleMode $styleMode = AStylePattern::STYLE_MODE
    ) {
        AReversiblePattern::__construct($interval, $reversed);
    }

    public function getStyleMode(): StyleMode
    {
        return $this->styleMode;
    }

    protected function pattern(): Traversable
    {
        return
            new ArrayObject($this->extractPattern());
    }

    /**
     * @return array<int,string>
     */
    protected function extractPattern(): array
    {
        return static::MULTI_PATTERN[$this->styleMode->value] ?? static::PATTERN;
    }
}
