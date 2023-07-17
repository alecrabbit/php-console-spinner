<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

abstract class AStylePattern extends AReversiblePattern implements IStylePattern
{
    protected const STYLE_MODE = StylingMethodOption::ANSI8;

    public function getStyleMode(): StylingMethodOption
    {
        return self::STYLE_MODE;
    }
}
