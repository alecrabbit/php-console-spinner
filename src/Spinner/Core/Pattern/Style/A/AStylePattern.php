<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

abstract class AStylePattern extends AReversiblePattern implements IStylePattern
{
    /** @var StyleMode */
    protected const STYLE_MODE = StyleMode::ANSI8;

    public function getStyleMode(): StyleMode
    {
        return static::STYLE_MODE;
    }
}
