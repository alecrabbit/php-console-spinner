<?php

declare(strict_types=1);
// 19.04.23
namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;

interface IPatternFactory
{
    public function getPattern(string $name): IPattern;
}
