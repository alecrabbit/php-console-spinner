<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

abstract class AStylePattern extends AReversiblePattern implements IStylePattern
{
    /** @var ColorMode */
    protected const COLOR_MODE = ColorMode::ANSI8;

    public function getColorMode(): ColorMode
    {
        return static::COLOR_MODE;
    }
}
