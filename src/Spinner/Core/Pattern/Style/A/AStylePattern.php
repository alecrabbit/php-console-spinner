<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Terminal\ColorMode;

abstract class AStylePattern extends APattern implements IStylePattern
{
    protected const COLOR_MODE = ColorMode::ANSI8;

    public function getColorMode(): ColorMode
    {
        return static::COLOR_MODE;
    }
}