<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\Contract;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use Traversable;

interface IStyleLegacyPattern extends ILegacyPattern
{
    public function getStyleMode(): StylingMethodOption;

    public function getEntries(StylingMethodOption $styleMode = StylingMethodOption::ANSI8): Traversable;
}
