<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;

interface IBakedPatternFactory
{
    public function createFromPattern(IPattern $name): IBakedPattern;
}
