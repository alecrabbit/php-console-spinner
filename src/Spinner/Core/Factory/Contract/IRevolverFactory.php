<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

interface IRevolverFactory
{
    public static function createFrom(IPattern $pattern): IRevolver;
}