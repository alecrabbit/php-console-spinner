<?php

declare(strict_types=1);
// 19.04.23
namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IBakedPattern;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;

interface IBakedPatternFactory
{
    public function createFromPattern(IPattern $name): IBakedPattern;
}
