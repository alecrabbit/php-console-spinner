<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;

abstract class AStylePattern extends AReversiblePattern implements IStyleLegacyPattern
{
    protected const STYLE_MODE = StylingMethodOption::ANSI8;

    public function getStyleMode(): StylingMethodOption
    {
        return self::STYLE_MODE;
    }
}
