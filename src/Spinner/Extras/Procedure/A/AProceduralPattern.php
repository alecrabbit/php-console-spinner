<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Extras\Procedure\Mixin\GetPatternNotAllowedTrait;

abstract class AProceduralPattern extends APattern implements IProceduralPattern
{
    use GetPatternNotAllowedTrait;
}