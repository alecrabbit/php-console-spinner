<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use Traversable;

interface IStylePattern extends IPattern
{
    public function getStyleMode(): StylingMethodOption;

    public function getEntries(StylingMethodOption $styleMode = StylingMethodOption::ANSI8): Traversable;
}
