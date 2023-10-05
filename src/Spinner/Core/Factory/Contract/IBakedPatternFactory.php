<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\ILegacyBakedPattern;

interface IBakedPatternFactory
{
    public function createFromPattern(ILegacyPattern $name): ILegacyBakedPattern;
}
