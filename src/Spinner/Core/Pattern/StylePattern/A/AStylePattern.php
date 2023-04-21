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

    public function getStyleMode(): OptionStyleMode
    {
        return self::STYLE_MODE;
    }
}
