<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\StylePattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use ArrayObject;
use Traversable;

abstract class AStylePattern extends AReversiblePattern implements IStylePattern
{
    protected const STYLE_MODE = OptionStyleMode::ANSI8;

    protected const PATTERN = ['#c0c0c0'];

    public function __construct(
        ?IInterval $interval = null,
        bool $reversed = false,
        protected ?OptionStyleMode $styleMode = null,
    ) {
        parent::__construct($interval, $reversed);
        $this->styleMode ??= self::STYLE_MODE;
    }

    public function getStyleMode(): OptionStyleMode
    {
        return $this->styleMode;
    }

    protected function entries(): Traversable
    {
        return new ArrayObject($this->extractPattern());
    }

    abstract protected function extractPattern(): array;
}
